<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\Zendesk\Observer;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class AdminZendesk implements ObserverInterface
{
    public const PATH_SUBDOMAIN = 'zendesk/config/zendesk_subdomain';

    // CONTACT US FEATURE
    public const PATH_ZENDESK_CONTACT_US_ENABLE = 'zendesk/ticket/frontend/contact_us';
    public const PATH_ZENDESK_CONTACT_US_EMAIL_BAK = 'zendesk/ticket/frontend/contact_us_email_bak';
    public const PATH_CONTACT_US_EMAIL = 'contact/email/recipient_email';

    public const PATH_ZENDESK_ORDER_FIELD_ID = 'zendesk/ticket/order_field_id';
    public const ORDER_FIELD_LABEL = 'Magento 2 Order Number';

    // CUSTOMER FIELD
    public const PATH_ZENDESK_CUSTOMER_FIELDS_ENABLE = 'zendesk/customer/enable_attribute_sync';
    public const PATH_ZENDESK_CUSTOMER_ATTRIBUTES_TO_SYNC = 'zendesk/customer/attributes_to_sync';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $writer;
    /**
     * @var \Wagento\Zendesk\Helper\Data
     */
    private $zendeskHelper;
    /**
     * @var \Wagento\Zendesk\Helper\Api\TicketField
     */
    private $ticketField;
    /**
     * @var \Wagento\Zendesk\Helper\Api\UserField
     */
    private $userField;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;

    /**
     * AdminZendesk constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $writer
     * @param \Wagento\Zendesk\Helper\Data $zendeskHelper
     * @param \Wagento\Zendesk\Helper\Api\TicketField $ticketField
     * @param \Wagento\Zendesk\Helper\Api\UserField $userField
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\Storage\WriterInterface $writer,
        \Wagento\Zendesk\Helper\Data $zendeskHelper,
        \Wagento\Zendesk\Helper\Api\TicketField $ticketField,
        \Wagento\Zendesk\Helper\Api\UserField $userField,
        \Magento\Framework\Message\ManagerInterface $messageManager
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->writer = $writer;
        $this->zendeskHelper = $zendeskHelper;
        $this->ticketField = $ticketField;
        $this->userField = $userField;
        $this->messageManager = $messageManager;
    }

    /**
     * Execute

     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $this->validateConnectionErrors();
        // Defaults for "global" scope
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $scopeId = 0;

        if ($websiteCode = $observer->getWebsite()) {
            $scope = \Magento\Store\Model\ScopeInterface::SCOPE_WEBSITES;
            $scopeId = $websiteCode;
        }

        if ($storeCode = $observer->getStore()) {
            $scope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
            $scopeId = $storeCode;
        }

        $this->configureContactUs($scope, $storeCode, $scopeId);
        $this->configureOrderCustomField($scope, $storeCode, $scopeId);
        $this->configureEndUserCustomField($scope, $storeCode, $scopeId);
        $this->configureStoreInformation($scope, $storeCode, $scopeId);
    }

    /**
     * Configure Contact Us

     * @param mixed $scope
     * @param mixed $storeCode
     * @param mixed $scopeId
     */
    private function configureContactUs($scope, $storeCode, $scopeId)
    {
        $enableEmail = $this->scopeConfig->getValue(self::PATH_ZENDESK_CONTACT_US_ENABLE, $scope, $storeCode);
        $currentEmail = $this->scopeConfig->getValue(self::PATH_CONTACT_US_EMAIL, $scope, $storeCode);
        $oldEmail = $this->scopeConfig->getValue(self::PATH_ZENDESK_CONTACT_US_EMAIL_BAK, $scope, $storeCode);
        $zendeskEmail = $this->zendeskHelper->getSupportEmail($scope, $storeCode);

        if ($enableEmail) {
            // If the email is already set, then do nothing
            if ($currentEmail !== $zendeskEmail) {
                // Ensure the email address value exists and is valid
                if (\Zend_Validate::is($zendeskEmail, 'EmailAddress')) {
                    $scopeWrite = $scope == 'store' ? 'stores' : $scope;
                    $this->writer->save(self::PATH_ZENDESK_CONTACT_US_EMAIL_BAK, $currentEmail, $scopeWrite, $scopeId);
                    $this->writer->save(self::PATH_CONTACT_US_EMAIL, $zendeskEmail, $scopeWrite, $scopeId);
                }
            }
        } else {
            // If the email hasn't been set, then we don't need to restore anything, otherwise overwrite the current
            // email address with the saved one
            if ($currentEmail === $zendeskEmail) {
                // If the old email is the Zendesk email then we still need to disable it, so set it to the "general"
                // contact email address
                if ($oldEmail === $zendeskEmail) {
                    $oldEmail = $this->scopeConfig->getValue('trans_email/ident_general/email', $scope, $storeCode);
                }
                $scopeWrite = $scope == 'store' ? 'stores' : $scope;
                $this->writer->save(self::PATH_CONTACT_US_EMAIL, $oldEmail, $scopeWrite, $scopeId);
            }
        }
    }

    /**
     * Configure Order Custom Field

     * @param mixed $scope
     * @param mixed $storeCode
     * @param mixed $scopeId
     */
    private function configureOrderCustomField($scope, $storeCode, $scopeId)
    {

        // MSaved ticket order fieldID
        $orderFieldId = $this->scopeConfig->getValue(self::PATH_ZENDESK_ORDER_FIELD_ID, $scope, $storeCode);

        if ($orderFieldId) {
            // Validate ticket order field
            $data = $this->ticketField->showTicketField($orderFieldId);
            if ($data) {
                // Validate field by type and title
                $validateTitle = isset($data['title']) && $data['title'] == self::ORDER_FIELD_LABEL;
                $validateType = isset($data['type']) && $data['type'] == 'text';
                if ($validateTitle && $validateType) {
                    return;
                }
            }
        }

        // Save field
        // search for created tickets
        $orderFields = $this->ticketField->getList();
        $userFieldKeys = array_column($orderFields, 'title', 'id');
        $filterId = array_keys($userFieldKeys, self::ORDER_FIELD_LABEL);

        if (count($filterId) == 0) {
            // create field
            $orderField = [
                'type' => 'text',
                'title' => self::ORDER_FIELD_LABEL,
                'description' => self::ORDER_FIELD_LABEL,
                'position' => 1,
            ];

            $zdTicketOrderFieldId = $this->ticketField->createTicketField($orderField);
            if ($zdTicketOrderFieldId) {
                $message = __('Order field added successfully.');
            }
        } elseif (count($filterId) == 1) {
            // Verify that only exists one field.
            $zdTicketOrderFieldId = $filterId['0'];
            $message = __('Order field updated successfully.');

        } else {
            // If result has many send message for correction.
            $url = $this->getUrl('/agent/admin/ticket_fields', $scope, $storeCode);
            $message = __(
                'Your Zendesk account has many Order Fields created, please <a href="%1" target="_blank">click here</a> to review.',
                $url
            );
            $this->messageManager->addError($message);
            return;
        }

        if (is_numeric($zdTicketOrderFieldId)) {
            $this->messageManager->addSuccessMessage($message);
            $scopeWrite = $scope == 'store' ? 'stores' : $scope;
            $this->writer->save(self::PATH_ZENDESK_ORDER_FIELD_ID, $zdTicketOrderFieldId, $scopeWrite, $scopeId);
            $this->zendeskHelper->cleanCacheConfig();
        }
    }

    /**
     * Configure End User Custom Field

     * @param mixed $scope
     * @param mixed $storeCode
     * @param mixed $scopeId
     */
    private function configureEndUserCustomField($scope, $storeCode, $scopeId)
    {
        if ($this->scopeConfig->getValue(self::PATH_ZENDESK_CUSTOMER_FIELDS_ENABLE, $scope, $storeCode)) {
            // REQUESTED ATTRIBUTES TO CREATED
            $configuredFields = $this->scopeConfig->getValue(self::PATH_ZENDESK_CUSTOMER_ATTRIBUTES_TO_SYNC, $scope, $storeCode);
            $configuredFieldsList = array_flip(explode(',', $configuredFields));

            // GET ZENDESK CUSTOMER FIELDS LIST
            $data = $this->userField->listUserFields();
            $userFieldKeys = array_flip(array_column($data, 'key', 'id'));

            // GET ATTRIBUTES THAT NEEDS TO BE CREATED
            $attributesToBeCreated = array_diff_key($configuredFieldsList, $userFieldKeys);
            if (count($attributesToBeCreated) == 0) {
                return;
            }

            // Create attributes
            if ($attributesToBeCreated) {
                $attributes = $this->getCustomerAttributes($attributesToBeCreated);
                foreach ($attributes as $attribute) {
                    $this->userField->createUserFields($attribute);
                }
                $message = __('Zendesk end-user attributes created correctly');
                $this->messageManager->addSuccessMessage($message);
            }
        }
    }

    /**
     * Get Customer Attributes

     * @param mixed $attributesToBeCreated
     * @return array
     */
    private function getCustomerAttributes($attributesToBeCreated)
    {
        // NEXT: For future release a customer attribute processor will be required for all customer eav attributes

        // TODO:  cusomter_since
        $customerAttributes = [
            'id' => [
                'type' => 'integer',
                'title' => 'ID',
                'description' => 'Magento Customer Id',
                'position' => 0,
                'active' => true,
                'key' => 'id'
            ],
            'group' => [
                'type' => 'text',
                'title' => 'Group',
                'description' => 'Magento Customer Group',
                'position' => 2,
                'active' => true,
                'key' => 'group'
            ],
            'lifetime_sale' => [
                'type' => 'decimal',
                'title' => 'Lifetime Sale',
                'description' => 'Magento Customer Lifetime Sale',
                'position' => 3,
                'active' => true,
                'key' => 'lifetime_sale'
            ],
            'average_sale' => [
                'type' => 'decimal',
                'title' => 'Average Sale',
                'description' => 'Magento Customer Average Sale',
                'position' => 4,
                'active' => true,
                'key' => 'average_sale'
            ],
            'logged_in' => [
                'type' => 'date',
                'title' => 'Last Logged In',
                'description' => 'Last Logged In',
                'position' => 5,
                'active' => true,
                'key' => 'logged_in'
            ],
            'name' => [
                'type' => 'text',
                'title' => 'Name',
                'description' => 'Magento Customer Name',
                'position' => 5,
                'active' => true,
                'key' => 'name'
            ],
            'last_name' => [
                'type' => 'text',
                'title' => 'Last Name',
                'description' => 'Magento Customer Last Name',
                'position' => 6,
                'active' => true,
                'key' => 'last_name'
            ],
            'email' => [
                'type' => 'text',
                'title' => 'Email',
                'description' => 'Magento Customer Email',
                'position' => 7,
                'active' => true,
                'key' => 'email'
            ],
            'phone_number' => [
                'type' => 'text',
                'title' => 'Phone Number',
                'description' => 'Magento Customer Phone Number',
                'position' => 8,
                'active' => true,
                'key' => 'phone_number'
            ]

        ];
        return array_intersect_key($customerAttributes, $attributesToBeCreated);
    }

    /**
     * Get Url

     * @param mixed $uri
     * @param mixed $scope
     * @param mixed $storeCode
     * @return string
     */
    private function getUrl($uri, $scope, $storeCode)
    {
        $subdomain = $this->scopeConfig->getValue(self::PATH_SUBDOMAIN, $scope, $storeCode);
        $pattern = 'https://%1$s.zendesk.com%2$s';
        return sprintf($pattern, $subdomain, $uri);
    }

    /**
     * validate Connection Errors
     */
    private function validateConnectionErrors()
    {
        $erroId = $this->scopeConfig->getValue(\Wagento\Zendesk\Helper\Api\ErrorHandler\Connector::XML_PATH_ERROR);
        $errors = \Wagento\Zendesk\Helper\Api\ErrorHandler\Connector::ERRO_MSG;
        if (isset($errors[$erroId])) {
            $this->messageManager->addErrorMessage($errors[$erroId]);
        }
    }

    /**
     * Configure Store Information

     * @param string $scope
     * @param mixed $storeCode
     * @param int $scopeId
     */
    private function configureStoreInformation(string $scope, $storeCode, int $scopeId)
    {
        $ticketFields = [
            'website_url_id' => [
                'type' => 'text',
                'title' => 'Magento 2 Website Url',
                'description' => 'Magento 2 Website Url',
                'position' => 2,
            ],
            'store_name_id' => [
                'type' => 'text',
                'title' => 'Magento 2 Store Name',
                'description' => 'Magento 2 Store Name',
                'position' => 3,
            ],
        ];
        foreach ($ticketFields as $code => $ticketField) {
            $configPath = "zendesk/ticket/{$code}";
            $configRead = $this->scopeConfig->getValue($configPath, $scope, $storeCode);
            if ($configRead == null) {
                $zdFieldId = $this->ticketField->createTicketField($ticketField);
                if (is_numeric($zdFieldId)) {
                    $scopeWrite = $scope == 'store' ? 'stores' : $scope;
                    $this->writer->save($configPath, $zdFieldId, $scopeWrite, $scopeId);
                }
            }
        }
    }
}
