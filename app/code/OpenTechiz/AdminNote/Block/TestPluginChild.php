<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 13/01/2021
 * Time: 13:20
 */

namespace OpenTechiz\AdminNote\Block;

use Magento\Framework\View\Element\Template;

class TestPluginChild extends TestPlugin
{
//    protected $_template ="OpenTechiz_AdminNote::testplugin.phtml";

//    public function testPlugin($originParam)
//    {
//        return $this->testPlugin2();
//    }
//
//    protected function testPlugin2()
//    {
//        return 222;
//    }
//
//    public function getDataTest()
//    {
//        return 'data test';
//    }
    public function execute()
    {
        var_dump($this->ditmemay);
    }
}
