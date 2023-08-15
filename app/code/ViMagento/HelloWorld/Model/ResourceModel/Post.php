<?php

namespace ViMagento\HelloWorld\Model\ResourceModel;

class Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('helloworld_post', 'post_id');
    }
}
