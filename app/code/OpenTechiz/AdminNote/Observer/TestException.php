<?php


namespace OpenTechiz\AdminNote\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class TestException  implements ObserverInterface
{
    /**
     * after customer order get data of order, handle and save into table bestseller_product_save_point and bestseller_product_custom_option
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $data = $observer->getEvent()->getData('data');
        $writer = new \Zend_Log_Writer_Stream(BP . '/var/log/xxxxx.log');
        $logger = new \Zend_Log();
        $logger->addWriter($writer);
        $logger->info('log event module AdminNote');
    }
}
