<?php

namespace Wagento\Zendesk\Model\Config\Source\App;

class OrderFields implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var $options
     */
    protected $options;

    /**
     * To Option Array

     * @return array|\string[][]
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options = [
            ['value' => 'link', 'label' => 'Link'],
            ['value' => 'status', 'label' => 'Status'],
            ['value' => 'total', 'label' => 'Grand Total'],
            ['value' => 'subtotal', 'label' => 'Subtotal'],
            ['value' => 'items', 'label' => 'Items'],
            ['value' => 'billing_address', 'label' => 'Billing Address'],
            ['value' => 'shipping_address', 'label' => 'Shipping Address'],
            ['value' => 'payment_method', 'label' => 'Payment Method'],
            ['value' => 'shipping_method', 'label' => 'Shipping Method'],
        ];

        return $this->options;
    }
}
