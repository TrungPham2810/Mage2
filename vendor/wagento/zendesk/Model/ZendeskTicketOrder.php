<?php

namespace Wagento\Zendesk\Model;

use Magento\Framework\Model\AbstractModel;
use Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface;

class ZendeskTicketOrder extends AbstractModel implements ZendeskTicketOrderInterface
{
    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\Wagento\Zendesk\Model\ResourceModel\ZendeskTicketOrder::class);
    }

    /**
     * @inheritDoc
     */
    public function getEntityId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    /**
     * @inheritDoc
     */
    public function setEntityId($entityId)
    {
        return $this->setData(self::ENTITY_ID, $entityId);
    }

    /**
     * @inheritDoc
     */
    public function getTicketId()
    {
        return $this->getData(self::TICKET_ID);
    }

    /**
     * @inheritDoc
     */
    public function setTicketId($ticketId)
    {
        return $this->setData(self::TICKET_ID, $ticketId);
    }

    /**
     * @inheritDoc
     */
    public function getIncrementId()
    {
        return $this->getData(self::INCREMENT_ID);
    }

    /**
     * @inheritDoc
     */
    public function setIncrementId($incrementId)
    {
        return $this->setData(self::INCREMENT_ID, $incrementId);
    }

    /**
     * @inheritDoc
     */
    public function getOrderId()
    {
        return $this->getData(self::ORDER_ID);
    }

    /**
     * @inheritDoc
     */
    public function setOrderId($orderId)
    {
        return $this->setData(self::ORDER_ID, $orderId);
    }
}
