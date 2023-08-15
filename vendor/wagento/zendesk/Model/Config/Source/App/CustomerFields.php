<?php

namespace Wagento\Zendesk\Model\Config\Source\App;

class CustomerFields implements \Magento\Framework\Data\OptionSourceInterface
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
            ['value' => 'created_at', 'label' => 'Created At'],
            ['value' => 'group', 'label' => 'Group'],
            ['value' => 'lifetime_sales', 'label' => 'Lifetime Sales'],
            ['value' => 'average_sale', 'label' => 'Average Sales'],
            ['value' => 'telephone', 'label' => 'Telephone'],
        ];
        return $this->options;
    }
}
