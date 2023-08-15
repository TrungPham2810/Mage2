<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Controller;

/**
 * Class AbstractUserAuthentication
 */
abstract class AbstractUserAuthentication extends \Magento\Framework\App\Action\Action
{
    public const IS_ALLOWED_CONFIG_PATH = [];

    /**
     * Get Is Allowed Config

     * @return array
     */
    public function getIsAllowedConfig()
    {
        return static::IS_ALLOWED_CONFIG_PATH;
    }
}
