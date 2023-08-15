<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Api\Data;

/**
 * Interface OrderReaderInterface
 */
interface OrderReaderInterface
{

    /*
     * Increment ID.
     */
    public const INCREMENT_ID = 'increment_id';
    /*
     * Created-at timestamp.
     */
    public const CREATED_AT = 'created_at';
    /*
     * Status.
     */
    public const STATUS = 'status';
    /*
     * Store name.
     */
    public const STORE_NAME = 'store_name';
    /*
     * Billing address.
     */
    public const BILLING_ADDRESS = 'billing_address';
    /*
     * Shipping address.
     */
    public const SHIPPING_ADDRESS = 'shipping_address';
    /*
     * Customer note.
     */
    public const CUSTOMER_NOTE = 'customer_note';

    /*
     * Order currency code.
     */
    public const ORDER_CURRENCY_CODE = 'order_currency_code';
    /*
     * Tax amount.
     */
    public const TAX_AMOUNT = 'tax_amount';
    /*
     * Subtotal.
     */
    public const SUBTOTAL = 'subtotal';
    /*
     * Shipping amount.
     */
    public const SHIPPING_AMOUNT = 'shipping_amount';
    /*
     * Discount amount.
     */
    public const DISCOUNT_AMOUNT = 'discount_amount';
    /*
     * Grand total.
     */
    public const GRAND_TOTAL = 'grand_total';
    /*
     * Total paid.
     */
    public const TOTAL_PAID = 'total_paid';
    /*
     * Total refunded.
     */
    public const TOTAL_REFUNDED = 'total_refunded';
    /*
     * Total due.
     */
    public const TOTAL_DUE = 'total_due';

    /*
     * Payment Method.
     */
    public const PAYMENT_METHOD = 'payment_method';
    /*
     * Shipping Method.
     */
    public const SHIPPING_METHOD = 'shipping_method';

    /*
     * Items.
     */
    public const ITEMS = 'items';

    /**
     * Gets the increment ID for the order.
     *
     * @return string|null Increment ID.
     */
    public function getIncrementId();

    /**
     * Sets the increment ID for the order.
     *
     * @param string $id
     * @return $this
     */
    public function setIncrementId($id);

    /**
     * Gets the created-at timestamp for the order.
     *
     * @return string|null Created-at timestamp.
     */
    public function getCreatedAt();

    /**
     * Sets the created-at timestamp for the order.
     *
     * @param string $createdAt timestamp
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Gets the status for the order.
     *
     * @return string|null Status.
     */
    public function getStatus();

    /**
     * Sets the status for the order.
     *
     * @param string $status
     * @return $this
     */
    public function setStatus($status);

    /**
     * Gets the store name for the order.
     *
     * @return string|null Store name.
     */
    public function getStoreName();

    /**
     * Sets the store name for the order.
     *
     * @param string $storeName
     * @return $this
     */
    public function setStoreName($storeName);

    /**
     * Gets the billing address, if any, for the order.
     *
     * @return string|null Billing address.
     */
    public function getBillingAddress();

    /**
     * Sets the billing address for the order.
     *
     * @param string $billingAddress
     * @return $this
     */
    public function setBillingAddress($billingAddress);

    /**
     * Gets the shipping address, if any, for the order.
     *
     * @return string|null Shipping address.
     */
    public function getShippingAddress();

    /**
     * Sets the shipping address for the order.
     *
     * @param string $shippingAddress
     * @return $this
     */
    public function setShippingAddress($shippingAddress);

    /**
     * Gets the order currency code for the order.
     *
     * @return string|null Order currency code.
     */
    public function getOrderCurrencyCode();

    /**
     * Sets the order currency code for the order.
     *
     * @param string $code
     * @return $this
     */
    public function setOrderCurrencyCode($code);

    /**
     * Gets the subtotal for the order.
     *
     * @return float|null Subtotal.
     */
    public function getSubtotal();

    /**
     * Sets the subtotal for the order.
     *
     * @param float $amount
     * @return $this
     */
    public function setSubtotal($amount);

    /**
     * Gets the shipping amount for the order.
     *
     * @return float|null Shipping amount.
     */
    public function getShippingAmount();

    /**
     * Sets the shipping amount for the order.
     *
     * @param float $amount
     * @return $this
     */
    public function setShippingAmount($amount);

    /**
     * Gets the discount amount for the order.
     *
     * @return float|null Discount amount.
     */
    public function getDiscountAmount();

    /**
     * Sets the discount amount for the order.
     *
     * @param float $amount
     * @return $this
     */
    public function setDiscountAmount($amount);

    /**
     * Gets the tax amount for the order.
     *
     * @return float|null Tax amount.
     */
    public function getTaxAmount();

    /**
     * Sets the tax amount for the order.
     *
     * @param float $amount
     * @return $this
     */
    public function setTaxAmount($amount);

    /**
     * Gets the grand total for the order.
     *
     * @return float Grand total.
     */
    public function getGrandTotal();

    /**
     * Sets the grand total for the order.
     *
     * @param float $amount
     * @return $this
     */
    public function setGrandTotal($amount);

    /**
     * Gets the total paid for the order.
     *
     * @return float|null Total paid.
     */
    public function getTotalPaid();
    /**
     * Sets the total paid for the order.
     *
     * @param float $totalPaid
     * @return $this
     */
    public function setTotalPaid($totalPaid);
    /**
     * Gets the total amount refunded amount for the order.
     *
     * @return float|null Total amount refunded.
     */
    public function getTotalRefunded();
    /**
     * Sets the total amount refunded amount for the order.
     *
     * @param float $totalRefunded
     * @return $this
     */
    public function setTotalRefunded($totalRefunded);
    /**
     * Gets the total due for the order.
     *
     * @return float|null Total due.
     */
    public function getTotalDue();
    /**
     * Sets the total due for the order.
     *
     * @param float $totalDue
     * @return $this
     */
    public function setTotalDue($totalDue);

    /**
     * Gets the payment method for the order.
     *
     * @return string | null Payment method.
     */
    public function getPaymentMethod();

    /**
     * Sets the payment method for the order.
     *
     * @param string $paymentMethod
     * @return string | null Payment method.
     */
    public function setPaymentMethod($paymentMethod);

    /**
     * Gets the shipping method for the order.
     *
     * @return string | null Shipping method.
     */
    public function getShippingMethod();

    /**
     * Sets the shipping method for the order.
     *
     * @param string $shippingMethod
     * @return string | null Shipping method.
     */
    public function setShippingMethod($shippingMethod);

    /**
     * Gets items for the order.
     *
     * @return \Wagento\Zendesk\Api\Data\OrderItemReaderInterface[] Array of items.
     */
    public function getItems();

    /**
     * Sets items for the order.
     *
     * @param \Wagento\Zendesk\Api\Data\OrderItemReaderInterface[] $items
     * @return $this
     */
    public function setItems($items);
}
