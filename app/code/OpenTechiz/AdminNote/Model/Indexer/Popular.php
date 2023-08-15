<?php


namespace OpenTechiz\AdminNote\Model\Indexer;


class Popular implements \Magento\Framework\Indexer\ActionInterface, \Magento\Framework\Mview\ActionInterface
{
    /*
     * Used by mview, allows process indexer in the "Update on schedule" mode
     */
    public function execute($ids){
//        $xx = implode('-', $ids);
//        //Used by mview, allows you to process multiple placed orders in the "Update on schedule" mode
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xxxxx.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info($xx);

    }

    /*
     * Will take all of the data and reindex
     * Will run when reindex via command line
     */
    public function executeFull(){
//        //Should take into account all placed orders in the system
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xxxxx.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info('executeFull');
    }

    /*
     * Works with a set of entity changed (may be massaction)
     */
    public function executeList(array $ids){
//        //Works with a set of placed orders (mass actions and so on)
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xxxxx.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info('executeList');
    }

    /*
     * Works in runtime for a single entity using plugins
     */
    public function executeRow($id){
        //Works in runtime for a single order using plugins
        //Works with a set of placed orders (mass actions and so on)
//        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/xxxxx.log');
//        $logger = new \Zend\Log\Logger();
//        $logger->addWriter($writer);
//        $logger->info('executeRow');
    }
}
