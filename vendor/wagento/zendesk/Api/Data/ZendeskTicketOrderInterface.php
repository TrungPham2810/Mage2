<?php
namespace Wagento\Zendesk\Api\Data;

interface ZendeskTicketOrderInterface
{
    public const ENTITY_ID = 'entity_id';
    public const ORDER_ID = 'order_id';
    public const TICKET_ID = 'ticket_id';
    public const INCREMENT_ID = 'increment_id';

    /**
     * Get entity_id

     * @return string|null
     */
    public function getEntityId();

    /**
     * Set entity_id

     * @param string $entityId
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     */
    public function setEntityId($entityId);

    /**
     * Get ticket_id

     * @return string|null
     */
    public function getTicketId();

    /**
     * Set ticket_id

     * @param string $ticketId
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     */
    public function setTicketId($ticketId);

    /**
     * Get increment_id

     * @return string|null
     */
    public function getIncrementId();

    /**
     * Set increment_id

     * @param string $incrementId
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     */
    public function setIncrementId($incrementId);

    /**
     * Get order_id

     * @return string|null
     */
    public function getOrderId();

    /**
     * Set order_id

     * @param string $orderId
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     */
    public function setOrderId($orderId);
}
