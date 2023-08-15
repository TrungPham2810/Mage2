<?php


namespace OpenTechiz\AdminNote\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use OpenTechiz\AdminNote\Api\AdminNoteRepositoryInterface;
use OpenTechiz\AdminNote\Api\Data\AdminNoteInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use OpenTechiz\AdminNote\Model\ResourceModel\AdminNote\Collection;
use Magento\Framework\Api\SortOrder;

/**
 * Class AdminNoteRepository
 * @package OpenTechiz\AdminNote\Model
 */
class AdminNoteRepository implements AdminNoteRepositoryInterface
{
    /**
     * @var AdminNoteFactory
     */
    protected $adminNoteFactory;
    /**
     * @var ResourceModel\AdminNote
     */
    protected $adminNoteResource;
    /**
     * @var ResourceModel\AdminNote\CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @var \OpenTechiz\AdminNote\Api\Data\AdminNoteSearchResultInterfaceFactory
     */
    protected $searchResultInterfaceFactory;

    /**
     * AdminNoteRepository constructor.
     * @param AdminNoteFactory                                                     $adminNoteFactory
     * @param ResourceModel\AdminNote                                              $adminNoteResource
     * @param ResourceModel\AdminNote\CollectionFactory                            $collectionFactory
     * @param \OpenTechiz\AdminNote\Api\Data\AdminNoteSearchResultInterfaceFactory $searchResultInterfaceFactory
     */
    public function __construct(
        AdminNoteFactory $adminNoteFactory ,
        \OpenTechiz\AdminNote\Model\ResourceModel\AdminNote $adminNoteResource,
        \OpenTechiz\AdminNote\Model\ResourceModel\AdminNote\CollectionFactory $collectionFactory,
        \OpenTechiz\AdminNote\Api\Data\AdminNoteSearchResultInterfaceFactory $searchResultInterfaceFactory
    ) {
        $this->adminNoteFactory = $adminNoteFactory;
        $this->adminNoteResource = $adminNoteResource;
        $this->collectionFactory = $collectionFactory;
        $this->searchResultInterfaceFactory = $searchResultInterfaceFactory;
    }

    public function getById($id)
    {
        $model = $this->adminNoteFactory->create();
        $this->adminNoteResource->load($model, 1);
        if (!$model->getNoteId()) {
            throw new NoSuchEntityException(__('Unable to find data with ID "%1"', $id));
        }
        return $model;
    }

    /**
     * @param AdminNoteInterface $model
     * @return mixed|AdminNoteInterface
     */
    public function save(AdminNoteInterface $model)
    {
        $this->adminNoteResource->save($model);
        return $model;
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws CouldNotDeleteException
     */
    public function deleteById($id)
    {
        try {
            $model = $this->adminNoteFactory->create();
            $this->adminNoteResource->load($model, $id);
            $this->adminNoteResource->delete($model);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(
                __('Could not delete the entry: %1', $exception->getMessage())
            );
        }

        return true;
    }


    public function getListApi($id)
    {
//        try{
//            $response = [
//                'name' => 'long',
//                'age' => '25',
//                'job' => 'developer'
//            ];
//        } catch (\Exception $e) {
//            $response=['error' => $e->getMessage()];
//        }
//        return json_encode($response);
        $model = $this->adminNoteFactory->create();
        $this->adminNoteResource->load($model, $id);
        if (!$model->getNoteId()) {
            throw new NoSuchEntityException(__('Unable to find data with ID "%1"', 1));
        }
//        return $model->getData();
        return json_encode($model->getData());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection              $collection
     */
    private function addFiltersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->searchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
