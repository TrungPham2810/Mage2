<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 13/01/2021
 * Time: 13:22
 */

namespace OpenTechiz\AdminNote\Plugin;


class TestPluginAroundAfterBefore
{

//    public function beforeTestPlugin(\OpenTechiz\AdminNote\Block\TestPlugin $object, $originParam)
//    {
//        $originParam = 'before param';
//        return $originParam;
//    }

//    public function aroundTestPlugin(\OpenTechiz\AdminNote\Block\TestPlugin $object,\Closure $proceed, $originParam)
//    {
//        if($originParam == 'xxxxxx') {
//            $originParam = 'param from around test';
//        }
//
////        return 'around param';
//        return $originParam;
//    }
//    public function aroundTestPlugin2(\OpenTechiz\AdminNote\Block\TestPlugin $object,\Closure $proceed)
//    {
////        return 'around param';
//        return 11111;
//    }

    public function afterTestPlugin(\OpenTechiz\AdminNote\Block\TestPlugin $object, $result)
    {
//        $xx = $object->getDataTest();
        if (true) {
          return "After param module OpenTechiz\AdminNote";
        }
        return $result;
    }

}
