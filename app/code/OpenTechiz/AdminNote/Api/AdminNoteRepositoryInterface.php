<?php


namespace OpenTechiz\AdminNote\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use OpenTechiz\AdminNote\Api\Data\AdminNoteInterface;

/**
 * Interface AdminNoteRepositoryInterface
 * @package OpenTechiz\AdminNote\Api
 */
interface AdminNoteRepositoryInterface
{
    /**
     * @param string $id
     * @return mixed
     */
    public function getById($id);

    /**
     * @param AdminNoteInterface $model
     * @return mixed
     */
    public function save(AdminNoteInterface $model);

    /**
     * @param string $id
     * @return mixed
     */
    public function deleteById($id);

    /**
     * @param SearchCriteriaInterface $searchCriteria
     * @return mixed
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * @param string $id
     * @return mixed
     */
    public function getListApi($id);
}
