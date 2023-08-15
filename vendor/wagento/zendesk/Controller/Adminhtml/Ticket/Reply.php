<?php

namespace Wagento\Zendesk\Controller\Adminhtml\Ticket;

use Magento\Framework\Controller\ResultFactory;

class Reply extends \Magento\Backend\App\Action
{

    /**
     * Reply Execute

     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        $ticketId = $this->getRequest()->getParam('id');
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set("Reply Ticket #{$ticketId}");
        return $resultPage;
    }
}
