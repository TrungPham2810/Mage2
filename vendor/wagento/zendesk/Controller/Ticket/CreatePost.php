<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\Zendesk\Controller\Ticket;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Wagento\Zendesk\Controller\AbstractUserAuthentication;

class CreatePost extends AbstractUserAuthentication
{
    public const IS_ALLOWED_CONFIG_PATH = [
        'zendesk/ticket/frontend/customer_account_open_ticket',
    ];

    /**
     * @var \Wagento\Zendesk\Helper\Api\Ticket
     */
    private $ticket;
    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $store;
    /**
     * @var \Wagento\Zendesk\Model\ZendeskTicketOrder
     */
    private $zendeskTicketOrder;
    /**
     * @var \Magento\Sales\Model\Order
     */
    private $order;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * CreatePost constructor.
     * @param Context $context
     * @param \Wagento\Zendesk\Helper\Api\Ticket $ticket
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Store\Model\StoreManagerInterface $store
     * @param \Wagento\Zendesk\Model\ZendeskTicketOrder $zendeskTicketOrder
     * @param \Magento\Sales\Model\Order $order
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        Context $context,
        \Wagento\Zendesk\Helper\Api\Ticket $ticket,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Store\Model\StoreManagerInterface $store,
        \Wagento\Zendesk\Model\ZendeskTicketOrder $zendeskTicketOrder,
        \Magento\Sales\Model\Order $order,
        \Psr\Log\LoggerInterface $logger
    ) {

        parent::__construct($context);
        $this->ticket = $ticket;
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->store = $store;
        $this->zendeskTicketOrder = $zendeskTicketOrder;
        $this->order = $order;
        $this->logger = $logger;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $customer = $this->customerSession->getCustomerDataObject();
        $customerAttribute = $customer->getCustomAttribute('zd_user_id');
        if ($customerAttribute == null) {
            $this->_eventManager->dispatch('sync_zd_user', ['customer' => $customer]);
            $customerAttribute = $customer->getCustomAttribute('zd_user_id');
        }

        $backParams = [];
        if ($customerAttribute) {
            // Update Customer Data
            $this->_eventManager->dispatch('update_zendesk_user_data', ['customer' => $customer]);

            $endUserId = $customerAttribute->getValue();
            $data = $this->getRequest()->getParams();

            $params = [
                'requester_id' => $endUserId,
                'submitter_id' => $endUserId,
                'subject' => $data['subject'],
                'comment' => [
                    'body' => $data['comment']
                ],
            ];

            // Add extra attributes validation
            $status = $this->scopeConfig->getValue('zendesk/ticket/status');
            if ($status) {
                $params['status'] = $status;
            }
            $type = $this->scopeConfig->getValue('zendesk/ticket/type');
            if ($type) {
                $params['type'] = $type;
            }
            $priority = $this->scopeConfig->getValue('zendesk/ticket/priority');
            if ($priority) {
                $params['priority'] = $priority;
            }

            // Verify order number send
            if (isset($data['order']) && $data['order'] != -1) {
                $ticketFieldId = $this->scopeConfig->getValue('zendesk/ticket/order_field_id');
                $params['custom_fields'][] = [
                    'id' => $ticketFieldId,
                    'value' => $data['order']
                ];
                // assign order id param in case something went wrong
                $backParams['orderid'] = $data['order'];
            }

            //  Add website and soter name
            if ($ticketWebsiteUrlFieldId = $this->scopeConfig->getValue('zendesk/ticket/website_url_id')) {
                $params['custom_fields'][] = [
                    'id' => $ticketWebsiteUrlFieldId,
                    'value' => $this->_url->getBaseUrl()
                ];
            }

            if ($ticketStoreNameFieldId = $this->scopeConfig->getValue('zendesk/ticket/store_name_id')) {
                $params['custom_fields'][] = [
                    'id' => $ticketStoreNameFieldId,
                    'value' => $this->getStoreName()
                ];
            }

            $response = $this->ticket->create($params);
            if (is_numeric($response)) {
                try {
                    $this->zendeskTicketOrder->setOrderId($this->order->loadByIncrementId($data['order'])->getId())
                        ->setIncrementId($data['order'])
                        ->setTicketId($response)
                        ->save();
                    $this->order->loadByIncrementId($data['order'])
                        ->setReferenceZendeskId(
                            $this->zendeskTicketOrder->getEntityId()
                        )
                        ->save();
                } catch (\Exception $exception) {
                    $this->logger->info(
                        "Wagento_Zendesk: Store ticket in separate table",
                        [$exception->getMessage()]
                    );
                }
                $this->messageManager->addSuccessMessage('Ticket create successfully.');
                return $resultRedirect->setPath('*/customer/tickets');
            }
        }

        $this->messageManager->addErrorMessage('Try again, if problem persist contact with store support.');
        return $resultRedirect->setPath('*/*/create', $backParams);
    }

    /**
     * Get Store Name

     * @return mixed|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getStoreName()
    {
        $zdName = $this->scopeConfig->getValue(
            'zendesk/ticket/store_name',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $name = $zdName != null ? $zdName : $this->store->getStore()->getName();

        return $name;
    }
}
