<?php

namespace OpenTechiz\AdminNote\Model;

use Magento\Framework\Model\AbstractModel;

class NoteUserRelation extends AbstractModel
{
    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init('OpenTechiz\AdminNote\Model\ResourceModel\NoteUserRelation');
    }

}

