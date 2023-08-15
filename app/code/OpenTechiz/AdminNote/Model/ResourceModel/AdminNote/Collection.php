<?php

namespace OpenTechiz\AdminNote\Model\ResourceModel\AdminNote;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Class Collection
 * @package OpenTechiz\AdminNote\Model\ResourceModel\AdminNote
 */
class Collection extends AbstractCollection
{
    /**
     * authSession
     *
     * @var Session
     */
    protected $authSession;
    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = 'adminnotes_adminnote_grid_collection';

    /**
     * Event object
     *
     * @var string
     */
    protected $_eventObject = 'adminnote_grid_collection';
    /**
     * primary key of table
     * @var string
     */
    protected $_idFieldName = 'note_id';

    /**
     * Collection constructor.
     * @param EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param FetchStrategyInterface $fetchStrategy
     * @param ManagerInterface $eventManager
     * @param AdapterInterface|null $connection
     * @param AbstractDb|null $resource
     * @param Session $authSession
     */
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        AdapterInterface $connection = null,
        AbstractDb $resource = null,
        Session $authSession
    ) {
        $this->authSession = $authSession;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    public function _construct()
    {
        $this->_init('OpenTechiz\AdminNote\Model\AdminNote', 'OpenTechiz\AdminNote\Model\ResourceModel\AdminNote');
    }

    /**
     * joinLeft table me_admin_note and me_admin_note_user_relation to get value of status
     * @return $this|AbstractCollection|void
     */
    protected function _initSelect()
    {
        parent::_initSelect();
        $user_id = $this->authSession->getUser()->getUserId();
        $this->addFilterToMap('note_id', 'main_table.note_id');
        $this->getSelect()->joinLeft(
            ['secondTable' => $this->getTable('me_admin_note_user_relation')],
            'main_table.note_id = secondTable.note_id AND secondTable.user_id='.$user_id,
            ['status']
        )->group(
            'main_table.note_id'
        );
        return $this;
    }
}
