<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/05/2019
 * Time: 17:11
 */

namespace OpenTechiz\AdminNote\Model\ResourceModel\NoteUserRelation;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package OpenTechiz\AdminNote\Model\ResourceModel\NoteUserRelation
 */
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('OpenTechiz\AdminNote\Model\NoteUserRelation', 'OpenTechiz\AdminNote\Model\ResourceModel\NoteUserRelation');
    }
}
