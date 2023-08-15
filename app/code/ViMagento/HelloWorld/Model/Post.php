<?php

namespace ViMagento\HelloWorld\Model;

class Post extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init('ViMagento\HelloWorld\Model\ResourceModel\Post');
    }
}
