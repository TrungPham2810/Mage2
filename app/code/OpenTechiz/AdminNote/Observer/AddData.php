<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 15/05/2019
 * Time: 09:46
 */

namespace OpenTechiz\AdminNote\Observer;

use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;

class AddData implements ObserverInterface
{


    /**
     * after customer order get data of order, handle and save into table bestseller_product_save_point and bestseller_product_custom_option
     * @param Observer $observer
     * @return $this|void
     */
    public function execute(Observer $observer)
    {
        $order = $observer->getEvent()->getData('order');
        $orderItems = $order->getAllItems();
        $orderId = $order->getId();
        foreach ($orderItems as $orderItem) {
            $orderItemId = $orderItem->getId();
            $options = $orderItem->getProductOptions();
            $product_id = $orderItem->getProductId();
        }//end foreach
    }
}
