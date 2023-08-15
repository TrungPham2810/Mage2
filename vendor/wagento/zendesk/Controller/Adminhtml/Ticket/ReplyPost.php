<?php

namespace Wagento\Zendesk\Controller\Adminhtml\Ticket;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

class ReplyPost extends \Magento\Backend\App\Action
{
    /**
     * @var \Wagento\Zendesk\Helper\Api\Ticket
     */
    private $ticketApi;

    /**
     * ReplyPost construct

     * @param Context $context
     * @param \Wagento\Zendesk\Helper\Api\Ticket $ticketApi
     */
    public function __construct(
        Context $context,
        \Wagento\Zendesk\Helper\Api\Ticket $ticketApi
    ) {
        parent::__construct($context);
        $this->ticketApi = $ticketApi;
    }

    /**
     * ReplyPost execute

     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $ticketId = $this->getRequest()->getParam('code');

        $comment = $this->getRequest()->getParam('comment');
        if (!empty($comment)) {

            $commentData = ["body" => $comment];

            $authorId = $this->getRequest()->getParam('author_id');
            if (!empty($authorId)) {
                $commentData['author_id'] = $authorId;
            }

            $request = ['comment' => $commentData];

            $status = $this->getRequest()->getParam('status');
            if (!empty($status)) {
                $request['status'] = $status;
            }

            $res = $this->ticketApi->update($ticketId, $request);

            if ($res) {
                $this->messageManager->addSuccessMessage(__('Your comment was succesfully send.'));
            } else {
                $this->messageManager->addSuccessMessage(__('Something went wrong please try again.'));
            }
        }
        return $resultRedirect->setPath('*/*/reply', ['id' => $ticketId]);
    }
}
