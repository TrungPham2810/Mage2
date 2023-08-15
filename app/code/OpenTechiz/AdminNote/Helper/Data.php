<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 26/04/2019
 * Time: 15:24
 */

namespace OpenTechiz\AdminNote\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

/**
 * Class Data
 * @package OpenTechiz\AdminNote\Helper
 */
class Data extends AbstractHelper
{

    /**
     * Data constructor.
     *
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function getCurrentPathId()
    {
        $_request = $this->_request;
        $fullAction = $this->_request->getFullActionName();

        $pathId = $fullAction;
        foreach ($_request->getParams() as $name => $param) {
            if ($name == 'id' || preg_match('#(\w+)_id#', $name)) {
                if (is_string($param)) {
                    $pathId .= '/' . $param;
                }
            }

            if (stristr($fullAction, 'system_config') && $name == 'section') {
                $pathId .= '/' . $name . '_' . $param;
            }
        }

        return $pathId;
    }

    /**
     * @return string
     */
    public function getCurrentPath()
    {
        $frontname = $this->_request->getModuleName();
        $controller = $this->_request->getControllerName();
        $action = $this->_request->getActionName();
        $params = $this->_request->getParams();

        $paramStr = '';

        if (!empty($params)) {
            foreach ($params as $k=>$v) {
                if (is_string($v)) {
                    $paramStr .= $k . '/' . $v . '/';
                }
            }
        }
        $path = $frontname . '/';

        $path .= $controller . '/' . $action . '/' . $paramStr;

        return $path;
    }
}
