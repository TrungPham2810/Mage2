<?php

namespace Wagento\Zendesk\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ZendeskTicketOrderRepositoryInterface
{

    /**
     * Save zendesk_ticket_order

     * @param \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface $zendeskTicketOrder
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface $zendeskTicketOrder
    );

    /**
     * Retrieve zendesk_ticket_order

     * @param string $zendeskTicketOrderId
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($zendeskTicketOrderId);

    /**
     * Retrieve zendesk_ticket_order matching the specified criteria.

     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wagento\Zendesk\Api\Data\ZendeskTicketOrderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete zendesk_ticket_order

     * @param \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface $zendeskTicketOrder
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface $zendeskTicketOrder
    );

    /**
     * Delete zendesk_ticket_order by ID

     * @param string $zendeskTicketOrderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($zendeskTicketOrderId);
}
