<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Wagento\Zendesk\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterface;
use Wagento\Zendesk\Api\Data\ZendeskTicketOrderInterfaceFactory;
use Wagento\Zendesk\Api\Data\ZendeskTicketOrderSearchResultsInterfaceFactory;
use Wagento\Zendesk\Api\ZendeskTicketOrderRepositoryInterface;
use Wagento\Zendesk\Model\ResourceModel\ZendeskTicketOrder as ResourceZendeskTicketOrder;
use Wagento\Zendesk\Model\ResourceModel\ZendeskTicketOrder\CollectionFactory as ZendeskTicketOrderCollectionFactory;

class ZendeskTicketOrderRepository implements ZendeskTicketOrderRepositoryInterface
{

    /**
     * @var ZendeskTicketOrderInterfaceFactory
     */
    protected $zendeskTicketOrderFactory;

    /**
     * @var ResourceZendeskTicketOrder
     */
    protected $resource;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ZendeskTicketOrderCollectionFactory
     */
    protected $zendeskTicketOrderCollectionFactory;

    /**
     * @var ZendeskTicketOrder
     */
    protected $searchResultsFactory;

    /**
     * @param ResourceZendeskTicketOrder $resource
     * @param ZendeskTicketOrderInterfaceFactory $zendeskTicketOrderFactory
     * @param ZendeskTicketOrderCollectionFactory $zendeskTicketOrderCollectionFactory
     * @param ZendeskTicketOrderSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceZendeskTicketOrder $resource,
        ZendeskTicketOrderInterfaceFactory $zendeskTicketOrderFactory,
        ZendeskTicketOrderCollectionFactory $zendeskTicketOrderCollectionFactory,
        ZendeskTicketOrderSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->zendeskTicketOrderFactory = $zendeskTicketOrderFactory;
        $this->zendeskTicketOrderCollectionFactory = $zendeskTicketOrderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(
        ZendeskTicketOrderInterface $zendeskTicketOrder
    ) {
        try {
            $this->resource->save($zendeskTicketOrder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the zendeskTicketOrder: %1',
                $exception->getMessage()
            ));
        }
        return $zendeskTicketOrder;
    }

    /**
     * @inheritDoc
     */
    public function get($zendeskTicketOrderId)
    {
        $zendeskTicketOrder = $this->zendeskTicketOrderFactory->create();
        $this->resource->load($zendeskTicketOrder, $zendeskTicketOrderId);
        if (!$zendeskTicketOrder->getId()) {
            throw new NoSuchEntityException(__('zendesk_ticket_order with id "%1" does not exist.', $zendeskTicketOrderId));
        }
        return $zendeskTicketOrder;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->zendeskTicketOrderCollectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }

        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(
        ZendeskTicketOrderInterface $zendeskTicketOrder
    ) {
        try {
            $zendeskTicketOrderModel = $this->zendeskTicketOrderFactory->create();
            $this->resource->load($zendeskTicketOrderModel, $zendeskTicketOrder->getEntityId());
            $this->resource->delete($zendeskTicketOrderModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the zendesk_ticket_order: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($zendeskTicketOrderId)
    {
        return $this->delete($this->get($zendeskTicketOrderId));
    }
}
