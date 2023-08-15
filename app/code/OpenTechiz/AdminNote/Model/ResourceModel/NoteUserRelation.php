<?php

namespace OpenTechiz\AdminNote\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class NoteUserRelation extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('me_admin_note_user_relation', 'id');
    }
}
