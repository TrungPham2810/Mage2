<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/12/2020
 * Time: 15:52
 */

namespace OpenTechiz\AdminNote\Controller\Test;


class Index extends \Magento\Framework\App\Action\Action
{
    protected $pageFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
//        $a = 7;
//        $b = 8;
//        echo "a = $a and b = $b";
//        echo "<br/>";
////        $a = $a + $b;
////        $b = $a - $b;
////        $a = $a - $b;
//
//        $a = $a * $b;
//        $b = $a / $b;
//        $a = $a / $b;
//        echo "After change value:";
//        echo "a = $a and b = $b";
//        echo "<br/>";
        $resultPage = $this->pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('AdminNote Test Index'));
        return $resultPage;
    }
}
