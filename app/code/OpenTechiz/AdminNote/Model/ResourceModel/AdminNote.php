<?php

namespace OpenTechiz\AdminNote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class AdminNote
 * @package OpenTechiz\AdminNote\Model\ResourceModel
 */
class AdminNote extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('me_admin_note', 'note_id');
    }
}
