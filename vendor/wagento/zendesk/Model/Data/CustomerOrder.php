<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Model\Data;

use Magento\Framework\UrlInterface;
use Wagento\Zendesk\Api\Data\CustomerOrderInterface;

class CustomerOrder extends \Magento\Framework\Api\AbstractExtensibleObject implements CustomerOrderInterface
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    private $orderFactory;
    /**
     * @var \Magento\Sales\Model\Order\Address\Renderer
     */
    private $addressRenderer;
    /**
     * @var \Magento\Framework\Pricing\Helper\Data
     */
    private $pricingHelper;
    /**
     * @var \Magento\Framework\Stdlib\DateTime\TimezoneInterface
     */
    private $localeDate;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;
    /**
     * @var \Magento\Backend\Model\Url
     */
    private $backendUrL;
    /**
     * @var UrlInterface
     */
    private $frontUrl;
    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    private $encryptor;

    /**
     * @param \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory
     * @param \Magento\Framework\Api\AttributeValueFactory $attributeValueFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Sales\Model\Order\Address\Renderer $addressRenderer
     * @param \Magento\Framework\Pricing\Helper\Data $pricingHelper
     * @param \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Backend\Model\Url $backendUrL
     * @param UrlInterface $frontUrl
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $attributeValueFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Sales\Model\Order\Address\Renderer $addressRenderer,
        \Magento\Framework\Pricing\Helper\Data $pricingHelper,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $localeDate,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Backend\Model\Url $backendUrL,
        \Magento\Framework\UrlInterface $frontUrl,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        array $data = []
    ) {

        parent::__construct($extensionFactory, $attributeValueFactory, $data);
        $this->orderFactory = $orderFactory;
        $this->addressRenderer = $addressRenderer;
        $this->pricingHelper = $pricingHelper;
        $this->localeDate = $localeDate;
        $this->storeManager = $storeManager;
        $this->scopeConfig = $scopeConfig;
        $this->backendUrL = $backendUrL;
        $this->encryptor = $encryptor;
        $this->frontUrl = $frontUrl;
    }

    /**
     * Get customer email

     * @return string
     */
    public function getEmail()
    {
        return $this->_get(self::EMAIL);
    }

    /**
     * Get customer firstname

     * @return string
     */
    public function getFirstname()
    {
        return $this->_get(self::FIRSTNAME);
    }

    /**
     * Get customer lastname

     * @return string
     */
    public function getLastname()
    {
        return $this->_get(self::LASTNAME);
    }

    /**
     * Get Orders

     * @return \Wagento\Zendesk\Api\Data\OrderReaderInterface[] Array of ord`ers.
     */
    public function getOrders()
    {
        if ($this->_get(self::ORDERS) == null) {
            $orders = $this->getOrderCollection();
            $this->setData(
                self::ORDERS,
                $orders
            );
        }
        return $this->_get(self::ORDERS);
    }

    /**
     * Get orders for the customer.
     *
     * @return \Wagento\Zendesk\Api\Data\OrderReaderInterface[] Array of orders.
     */
    public function getZdOrder()
    {
        $zdOrder = $this->_get(self::ZD_ORDER);
        if (!empty($zdOrder)) {
            $orderInstance = $this->orderFactory->create();
            /** @var \Magento\Sales\Model\Order $order */
            $order = $orderInstance->loadByIncrementId($zdOrder);
            if ($order->getId()) {
                $this->setData(
                    self::ZD_ORDER,
                    [$this->getOrderDataByModel($order)]
                );
            }
        }
        return $this->_get(self::ZD_ORDER);
    }

    /**
     * @inheritdoc
     */
    public function getCustomerData()
    {
        return $this->_get(self::CUSTOMER_DATA);
    }

    /**
     * Set email address
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * Set first name
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname)
    {
        return $this->setData(self::FIRSTNAME, $firstname);
    }

    /**
     * Set last name
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname)
    {
        return $this->setData(self::LASTNAME, $lastname);
    }

    /**
     * Sets orders for the customer.
     *
     * @param \Wagento\Zendesk\Api\Data\OrderReaderInterface[] $orders
     * @return $this
     */
    public function setOrders($orders)
    {
        return $this->setData(self::ORDERS, $orders);
    }

    /**
     * Sets orders for the customer.
     *
     * @param \Wagento\Zendesk\Api\Data\OrderReaderInterface[] $zdOrder
     * @return $this
     */
    public function setZdOrder($zdOrder)
    {
        return $this->setData(self::ZD_ORDER, $zdOrder);
    }

    /**
     * Set Customer Data

     * @param \Wagento\Zendesk\Api\Data\CustomerDataInterface[] $customerData
     * @return CustomerOrder
     */
    public function setCustomerData($customerData)
    {
        return $this->setData(self::CUSTOMER_DATA, $customerData);
    }

    /**
     * Get created at time
     *
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->_get(self::CREATED_AT);
    }

    /**
     * Set created at time
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get customer group

     * @return string
     */
    public function getGroup()
    {
        return $this->_get(self::GROUP);
    }

    /**
     * Set group
     *
     * @param string $group
     * @return $this
     */
    public function setGroup($group)
    {
        return $this->setData(self::GROUP, $group);
    }

    /**
     * Get lifetime sales for the customer.
     *
     * @return float|null
     */
    public function getLifetimeSales()
    {
        return $this->_get(self::LIFETIME_SALES);
    }

    /**
     * Set lifetime sales for the customer.
     *
     * @param float $lifetimeSales
     * @return $this
     */
    public function setLifetimeSales($lifetimeSales)
    {
        return $this->setData(self::LIFETIME_SALES, $lifetimeSales);
    }

    /**
     * @inheritdoc
     */
    public function getAverageSale()
    {
        return $this->_get(self::AVERAGE_SALE);
    }

    /**
     * Set Average Sale

     * @param string $averageSale
     * @return CustomerOrder
     */
    public function setAverageSale($averageSale)
    {
        return $this->setData(self::AVERAGE_SALE, $averageSale);
    }

    /**
     * Get customer telephone.

     * @return string
     */
    public function getTelephone()
    {
        return $this->_get(self::TELEPHONE);
    }

    /**
     * Set customer telephone.

     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * Get Order Collection

     * @return \Wagento\Zendesk\Api\Data\OrderReaderInterface[]
     */
    private function getOrderCollection()
    {
        $email = $this->getEmail();

        $orderInstance = $this->orderFactory->create();
        $orderCollection = $orderInstance->getCollection();

        // Order Limit
        $orderLimit = $this->scopeConfig->getValue('zendesk/zendesk_m2app/order_qty_limit');
        if (isset($orderLimit) && is_numeric($orderLimit)) {
            $orderCollection->setPageSize($orderLimit);
        }
        //Load rest of information
        $orderCollection->addFieldToFilter('customer_email', $email)
            ->setOrder('entity_id', 'DESC');

        $orders = [];
        foreach ($orderCollection as $order) {
            $orders[] = $this->getOrderDataByModel($order);
        }
        return $orders;
    }

    /**
     * Retrieve order information

     * @param int $id
     * @return array
     */
    private function getOrderData($id)
    {
        $orderInstance = $this->orderFactory->create();
        /** @var \Magento\Sales\Model\Order $order */
        $order = $orderInstance->load($id);
        return $this->getOrderDataByModel($order);
    }

    /**
     * Get Order Data By Model

     * @param \Magento\Sales\Model\Order $order
     * @return array
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getOrderDataByModel(\Magento\Sales\Model\Order $order)
    {
        $fields = $this->scopeConfig->getValue('zendesk/zendesk_m2app/order_fields');
        $toDisplayFields = array_flip(explode(",", $fields));

        $billing_address = null;
        if (isset($toDisplayFields['billing_address'])) {
            /** @var \Magento\Sales\Model\Order\Address $billing */
            $billing = $order->getBillingAddress();
            $billing_address = '-';
            if ($billing) {
                $billing_address = $this->addressRenderer->format($billing, 'html');
            }
        }

        $shipping_address = null;
        if (isset($toDisplayFields['shipping_address'])) {
            /** @var \Magento\Sales\Model\Order\Address $shipping */
            $shipping = $order->getShippingAddress();
            $shipping_address = '-';
            if ($shipping) {
                $shipping_address = $this->addressRenderer->format($shipping, 'html');
            }
        }

        $createdAt = $order->getCreatedAt();

        $formattedCreatedAt = $this->formatDate($createdAt, \IntlDateFormatter::MEDIUM) . ', ' . $this->formatTime($createdAt);
        $storeName = $this->storeManager->getStore($order->getStoreId())->getWebsite()->getName();

        $paymentMethod = null;
        if (isset($toDisplayFields['payment_method'])) {
            $paymentDescription = $order->getPayment()->getMethodInstance()->getTitle();
            $paymentMethod = $paymentDescription ? $paymentDescription : '-';
        }

        $shippingMethod = null;
        if (isset($toDisplayFields['shipping_method'])) {
            $shippingDescription = $order->getShippingDescription();
            $shippingMethod = $shippingDescription ? $shippingDescription : '-';
        }
        //order_status,order_items,order_subtotal,order_total,billing_address,shipping_address,payment_method,shipping_method
        $url = isset($toDisplayFields['link']) ? $this->maskViewOrderUrl($order->getId()) : null;
        $status = isset($toDisplayFields['status']) ? $order->getStatus() : null;
        $subtotal = isset($toDisplayFields['subtotal']) ? $this->formatPrice($order->getSubtotal()) : null;
        $grand_total = isset($toDisplayFields['total']) ? $this->formatPrice($order->getGrandTotal()) : null;

        $orderInfo = [
            'url' => $url,
            'increment_id' => $order->getIncrementId(),
            'created_at' => $formattedCreatedAt,
            'status' => $status,
            'store_name' => $storeName,
            'billing_address' => $billing_address,
            'shipping_address' => $shipping_address,
            'subtotal' => $subtotal,
            'shipping_amount' => $this->formatPrice($order->getShippingAmount()),
            'discount_amount' => $this->formatPrice($order->getDiscountAmount()),
            'tax_amount' => $this->formatPrice($order->getTaxAmount()),
            'grand_total' => $grand_total,
            'total_paid' => $this->formatPrice($order->getTotalPaid()),
            'total_refunded' => $this->formatPrice($order->getTotalRefunded()),
            'total_due' => $this->formatPrice($order->getTotalDue()),
            'payment_method' => $paymentMethod,
            'shipping_method' => $shippingMethod,
            'items' => null
        ];

        if (isset($toDisplayFields['items'])) {
            foreach ($order->getItems() as $item) {
                // original float values
                $originalPrice = $item->getOriginalPrice();
                $price = $item->getPrice();
                $qtyOrdered = $item->getQtyOrdered() * 1;
                $subtotal = $qtyOrdered * $price;
                $taxAmount = $item->getTaxAmount();
                $taxPercent = $item->getTaxPercent() * 1;
                $discountAmount = $item->getDiscountAmount();
                $rowTotal = $item->getRowTotal() - $discountAmount;

                $itemInfo['name'] = $item->getName();
                $itemInfo['sku'] = $item->getSku();
                $itemInfo['status'] = $item->getStatus();
                $itemInfo['original_price'] = $this->formatPrice($originalPrice);
                $itemInfo['price'] = $this->formatPrice($price);
                $itemInfo['qty_ordered'] = $qtyOrdered;
                $itemInfo['subtotal'] = $this->formatPrice($subtotal);
                $itemInfo['tax_amount'] = $this->formatPrice($taxAmount);
                $itemInfo['tax_percent'] = $taxPercent;
                $itemInfo['discount'] = $this->formatPrice($discountAmount);
                $itemInfo['total'] = $this->formatPrice($rowTotal);
                $orderInfo['items'][] = $itemInfo;
            }
        }

        return $orderInfo;
    }

    /**
     * Mask View Order Url

     * @param mixed $orderId
     * @return string
     */
    private function maskViewOrderUrl($orderId)
    {
        $encH = $this->encryptor->encrypt("orderId|{$orderId}");
        $b64H = base64_encode($encH);
        $urlPath = $this->frontUrl->getUrl('zendesk/vieworder');
        return "{$urlPath}?h={$b64H}";
    }

    /**
     * Retrieve formatting price

     * @param mixed $price
     * @return float|string
     */
    public function formatPrice($price)
    {
        return $this->pricingHelper->currency($price, true, false);
    }

    /**
     * Retrieve formatting date

     * @param null|string|\DateTimeInterface $date
     * @param int $format
     * @param bool $showTime
     * @param null|string $timezone
     * @return string
     */
    public function formatDate(
        $date = null,
        $format = \IntlDateFormatter::SHORT,
        $showTime = false,
        $timezone = null
    ) {

        $date = $date instanceof \DateTimeInterface ? $date : new \DateTime($date);
        return $this->localeDate->formatDateTime(
            $date,
            $format,
            $showTime ? $format : \IntlDateFormatter::NONE,
            null,
            $timezone
        );
    }

    /**
     * Retrieve formatting time

     * @param \DateTime|string|null $time
     * @param int $format
     * @param bool $showDate
     * @return  string
     */
    public function formatTime(
        $time = null,
        $format = \IntlDateFormatter::SHORT,
        $showDate = false
    ) {

        $time = $time instanceof \DateTimeInterface ? $time : new \DateTime($time);
        return $this->localeDate->formatDateTime(
            $time,
            $showDate ? $format : \IntlDateFormatter::NONE,
            $format
        );
    }
}
