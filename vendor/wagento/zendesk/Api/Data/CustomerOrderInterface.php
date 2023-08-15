<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Api\Data;

interface CustomerOrderInterface
{

    /**#@+
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    public const EMAIL = 'email';
    public const FIRSTNAME = 'firstname';
    public const LASTNAME = 'lastname';
    public const CREATED_AT = 'created_at';
    public const GROUP = 'group';
    public const LIFETIME_SALES = 'lifetime_sales';
    public const AVERAGE_SALE = 'average_sale';
    public const TELEPHONE = 'telephone';
    public const ORDERS = 'orders';
    public const ZD_ORDER = 'zd_order';
    public const CUSTOMER_DATA = 'customer_data';

    /**
     * Get customer email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set email address.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * Get customer firstname.
     *
     * @return string
     */
    public function getFirstname();

    /**
     * Set first name.
     *
     * @param string $firstname
     * @return $this
     */
    public function setFirstname($firstname);

    /**
     * Get customer lastname.
     *
     * @return string
     */
    public function getLastname();

    /**
     * Set last name.
     *
     * @param string $lastname
     * @return $this
     */
    public function setLastname($lastname);

    /**
     * Get created at time.
     *
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at time.
     *
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get customer group.
     *
     * @return string
     */
    public function getGroup();

    /**
     * Set group.
     *
     * @param string $group
     * @return $this
     */
    public function setGroup($group);

    /**
     * Get lifetime sales for the customer.
     *
     * @return string|null
     */
    public function getLifetimeSales();

    /**
     * Set lifetime sales for the customer.
     *
     * @param string $lifetimeSales
     * @return $this
     */
    public function setLifetimeSales($lifetimeSales);

    /**
     * Get average sales for the customer.
     *
     * @return string|null
     */
    public function getAverageSale();

    /**
     * Set average sales for the customer.
     *
     * @param string $averageSale
     * @return $this
     */
    public function setAverageSale($averageSale);

    /**
     * Get customer telephone.
     *
     * @return string
     */
    public function getTelephone();

    /**
     * Set customer telephone.
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get orders for the customer.
     *
     * @return \Wagento\Zendesk\Api\Data\OrderReaderInterface[] Array of orders.
     */
    public function getOrders();

    /**
     * Sets orders for the customer.
     *
     * @param \Wagento\Zendesk\Api\Data\OrderReaderInterface[] $orders
     * @return $this
     */
    public function setOrders($orders);

    /**
     * Get orders for the customer.
     *
     * @return \Wagento\Zendesk\Api\Data\OrderReaderInterface[] Array of orders.
     */
    public function getZdOrder();

    /**
     * Sets orders for the customer.
     *
     * @param \Wagento\Zendesk\Api\Data\OrderReaderInterface[] $zdOrder
     * @return $this
     */
    public function setZdOrder($zdOrder);

    /**
     * Get customer data.
     *
     * @return \Wagento\Zendesk\Api\Data\CustomerDataInterface[].
     */
    public function getCustomerData();

    /**
     * Sets customer data.
     *
     * @param \Wagento\Zendesk\Api\Data\CustomerDataInterface[] $customerData
     * @return $this
     */
    public function setCustomerData($customerData);
}
