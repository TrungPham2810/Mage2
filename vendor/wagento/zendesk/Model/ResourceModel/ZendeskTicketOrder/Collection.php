<?php

namespace Wagento\Zendesk\Model\ResourceModel\ZendeskTicketOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritDoc
     * @var $_idFieldName
     */
    protected $_idFieldName = 'entity_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \Wagento\Zendesk\Model\ZendeskTicketOrder::class,
            \Wagento\Zendesk\Model\ResourceModel\ZendeskTicketOrder::class
        );
    }
}
