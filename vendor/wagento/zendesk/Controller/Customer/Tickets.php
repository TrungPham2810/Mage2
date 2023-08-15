<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Controller\Customer;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;

class Tickets extends \Wagento\Zendesk\Controller\AbstractUserAuthentication
{
    public const IS_ALLOWED_CONFIG_PATH = [
        'zendesk/ticket/frontend/customer_account',
        'zendesk/ticket/frontend/customer_account_open_ticket',
        ];

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return \Magento\Framework\Controller\ResultInterface|ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function execute()
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set(__("My Tickets"));

        return $resultPage;
    }
}
