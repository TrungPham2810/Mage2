<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 13/01/2021
 * Time: 13:20
 */

namespace OpenTechiz\AdminNote\Block;

use Magento\Framework\View\Element\Template;

class TestPluginOverride extends TestPlugin
{
     public function execute()
     {
         var_dump($this->ditmemay);
     }
//    protected $_template ="OpenTechiz_AdminNote::testplugin.phtml";

//    protected function testPlugin($originParam)
//    {
//        return 'override abstract true';
//    }
//    protected function testPlugin2()
//    {
//        return 'test protected override 2';
//    }
//
//    public function testOverride()
//    {
//        return 'success override';
//    }
}
