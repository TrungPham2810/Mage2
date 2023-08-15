<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\Zendesk\Controller\Plugin;

use Magento\Framework\App\RequestInterface;
use Wagento\Zendesk\Controller\AbstractUserAuthentication;

class Authentication
{
    /**
     * @var \Magento\Customer\Model\Url
     */
    protected $customerUrl;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @param \Magento\Customer\Model\Url $customerUrl
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        \Magento\Customer\Model\Url $customerUrl,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {

        $this->customerUrl = $customerUrl;
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Authenticate user
     *
     * @param \Magento\Framework\App\ActionInterface $subject
     * @param RequestInterface $request
     * @return void
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(AbstractUserAuthentication $subject, RequestInterface $request)
    {
        $allConfigDisabled = true;
        $allowedConfigList = $subject->getIsAllowedConfig();
        foreach ($allowedConfigList as $allowedConfig) {
            if ($this->scopeConfig->getValue($allowedConfig, \Magento\Store\Model\ScopeInterface::SCOPE_STORE) == 1) {
                $allConfigDisabled = false;
                break;
            }
        }
        if ($allConfigDisabled) {
            $subject->getActionFlag()->set('', $subject::FLAG_NO_DISPATCH, true);
        }

        $loginUrl = $this->customerUrl->getLoginUrl();

        if (!$this->customerSession->authenticate($loginUrl)) {
            $subject->getActionFlag()->set('', $subject::FLAG_NO_DISPATCH, true);
        }
    }
}
