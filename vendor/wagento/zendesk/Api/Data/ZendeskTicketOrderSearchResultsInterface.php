<?php

namespace Wagento\Zendesk\Api\Data;

interface ZendeskTicketOrderSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get zendesk_ticket_order list.

     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface[]
     */
    public function getItems();

    /**
     * Set entity_id list.

     * @param \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
