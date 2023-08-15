<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Model;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Customer\Model\CustomerFactory;
use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Sales\Model\OrderFactory;
use Wagento\Zendesk\Api\CustomerOrderRepositoryInterface;
use Wagento\Zendesk\Api\Data\CustomerOrderInterface;

class CustomerOrderRepository implements CustomerOrderRepositoryInterface
{
    /**
     * @var CustomerOrderInterface
     */
    protected $customerOrder;
    /**
     * @var CustomerFactory
     */
    protected $customerFactory;
    /**
     * @var OrderFactory
     */
    private $orderFactory;
    /**
     * @var DataObjectHelper
     */
    private $dataObjectHelper;
    /**
     * @var GroupRepositoryInterface
     */
    private $groupRepository;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory
     */
    private $customerCollectionFactory;
    /**
     * @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * CustomerOrderRepository constructor.

     * @param CustomerOrderInterface $customerOrder
     * @param CustomerFactory $customerFactory
     * @param OrderFactory $orderFactory
     * @param GroupRepositoryInterface $groupRepository
     * @param DataObjectHelper $dataObjectHelper
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        CustomerOrderInterface $customerOrder,
        CustomerFactory $customerFactory,
        OrderFactory $orderFactory,
        GroupRepositoryInterface $groupRepository,
        DataObjectHelper $dataObjectHelper,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory  $orderCollectionFactory
    ) {

        $this->customerFactory = $customerFactory;
        $this->customerOrder = $customerOrder;
        $this->orderFactory = $orderFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->groupRepository = $groupRepository;
        $this->scopeConfig = $scopeConfig;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Loads a specified customer order information.
     *
     * @param string $email
     * @param string $order
     * @return \Wagento\Zendesk\Api\Data\CustomerOrderInterface Customer Order Interface.
     */
    public function get($email, string $order = "")
    {
        if (!$email) {
            throw new InputException(__('Email required'));
        }
        $customerInfo = $this->getCustomerData($email);
        if (!empty($order)) {
            $customerInfo['zd_order'] = $order;
        }

        if (!$customerInfo) {
            throw new NoSuchEntityException(__('Requested customer doesn\'t exist'));
        }

        $this->dataObjectHelper->populateWithArray(
            $this->customerOrder,
            $customerInfo,
            \Wagento\Zendesk\Api\Data\CustomerOrderInterface::class
        );
        return $this->customerOrder;
    }

    /**
     * Get Customer Data

     * @param string $email
     * @return array | false
     */
    private function getCustomerData($email)
    {
        $customerData = [];

        $configuredFields = $this->scopeConfig->getValue('zendesk/zendesk_m2app/customer_fields');
        $toDisplayFields = array_flip(explode(",", $configuredFields));
        // email,created_at,group,lifetime_sales,telephone,firstname,lastname

        /** @var \Magento\Customer\Model\Customer $customer */
        $customer = $this->customerCollectionFactory->create()
            ->addAttributeToFilter('email', $email)
            ->getFirstItem();

        if ($customer) {
            $customerData['email'] = $customer->getEmail();
            $customerData['firstname'] = $customer->getFirstname();
            $customerData['lastname'] = $customer->getLastname();

            if (isset($toDisplayFields['created_at'])) {
                $customerData['created_at'] = $this->customerOrder->formatDate($customer->getData('created_at'));
            }
            if (isset($toDisplayFields['group'])) {
                try {
                    $groupId = $customer->getGroupId();
                    $customerData['group'] = $this->groupRepository->getById($groupId)->getCode();
                } catch (\Exception $exception) {
                }
            }
            $defBillAddr = $customer->getDefaultBillingAddress();
            if (isset($toDisplayFields['telephone']) && $defBillAddr) {
                $customerData['telephone'] = $defBillAddr->getTelephone();
            }
        } else {
            /* Get customer info from table customer_entity */
            /** @var \Magento\Sales\Model\Order $order */

            $order = $this->orderCollectionFactory->create()
                ->addFieldToFilter('customer_email', $email)
                ->setPageSize(1)
                ->setCurPage(1)
                ->setOrder('entity_id', 'DESC')
                ->getFirstItem();

            $customerData['email'] = $order->getCustomerEmail();
            $customerData['firstname'] = $order->getCustomerFirstname();
            $customerData['lastname'] = $order->getCustomerLastname();

            if (isset($toDisplayFields['created_at'])) {
                $customerData['created_at'] = '-';
            }
            if (isset($toDisplayFields['group'])) {
                $customerData['group'] = 'Guest';
            }
            $billAddr = $order->getBillingAddress();
            if (isset($toDisplayFields['telephone']) && $billAddr) {
                $customerData['telephone'] = $billAddr->getTelephone();
            }
        }

        if (isset($toDisplayFields['lifetime_sales']) || isset($toDisplayFields['average_sale'])) {
            // Order Connection
            $order = $this->orderFactory->create();
            $orderResource = $order->getResource();
            $orderConnection = $orderResource->getConnection();
            $orderTable = $orderResource->getMainTable();

            if (isset($toDisplayFields['lifetime_sales'])) {
                $select = $orderConnection->select()->from(
                    $orderTable,
                    ['lifetime_sales' => 'SUM(subtotal_invoiced)']
                )->where('customer_email LIKE ?', $email);

                $select_res = $orderConnection->fetchOne($select);
                $lifetimeSales = isset($select_res) && is_numeric($select_res) ? $select_res : 0;

                $customerData['lifetime_sales'] = $this->customerOrder->formatPrice($lifetimeSales);
            }
            if (isset($toDisplayFields['average_sale'])) {

                $select = $orderConnection->select()->from(
                    $orderTable,
                    ['average_sale' => 'AVG( IFNULL( subtotal_invoiced, 0 ) )']
                )->where('customer_email LIKE ? AND subtotal_invoiced IS NOT NULL ', $email);

                $select_res = $orderConnection->fetchOne($select);
                $averageSale = isset($select_res) && is_numeric($select_res) ? $select_res : 0;

                $customerData['average_sale'] = $this->customerOrder->formatPrice($averageSale);
            }
        }
        return $customerData;
    }
}
