<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 25/04/2019
 * Time: 18:11
 */

namespace OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\AdminNote\Model\ResourceModel\AdminNote\CollectionFactory;

/**
 * Class MassHide
 * @package OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes
 */
class MassHide extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    /**
     * @param Context           $context
     * @param Filter            $filter
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->updateStatus(1);
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been hidden.', $collectionSize));
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}
