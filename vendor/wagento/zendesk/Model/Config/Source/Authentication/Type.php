<?php

namespace Wagento\Zendesk\Model\Config\Source\Authentication;

class Type implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var $options
     */
    protected $options;

    /**
     * @inheritDoc
     */
    public function toOptionArray()
    {
        if ($this->options !== null) {
            return $this->options;
        }

        $this->options = [
            ['label' => 'API token', 'value' => 'api_token'],
            ['label' => 'OAuth access token', 'value' => 'oauth_token'],
        ];

        return $this->options;
    }
}
