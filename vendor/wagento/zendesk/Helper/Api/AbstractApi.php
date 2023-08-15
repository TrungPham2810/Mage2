<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Helper\Api;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

/**
 * This improves defaults magento's http implementation for curl
 * Class AbstractApi
 */
abstract class AbstractApi extends AbstractHelper
{
    public const PATH_AUTH_TYPE = 'zendesk/config/auth_type';
    public const PATH_USER_EMAIL = 'zendesk/config/api_email';
    /**
     * @var \Wagento\Zendesk\Helper\Data
     */
    protected $zendeskHelper;
    /**
     * @var Sources\Client
     */
    private $client;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * AbstractApi constructor.

     * @param Context $context
     * @param Sources\Client $client
     * @param \Wagento\Zendesk\Helper\Data $zendeskHelper
     */
    public function __construct(
        Context $context,
        \Wagento\Zendesk\Helper\Api\Sources\Client $client,
        \Wagento\Zendesk\Helper\Data $zendeskHelper,
        StoreManagerInterface $storeManager
    ) {

        parent::__construct($context);
        $this->zendeskHelper = $zendeskHelper;
        $this->client = $client;
        $this->storeManager = $storeManager;
    }

    /**
     * Get

     * @param string $endpoint
     * @param array
     */
    protected function get($endpoint, $params = [])
    {
        $this->prepareAuth();
        if (count($params) > 0) {
            $args = [];
            foreach ($params as $arg => $val) {
                $args[] = urlencode($arg) . '=' . urlencode($val);
            }
            $endpoint .= '?' . implode('&', $args);
        }
        $uri = $this->zendeskHelper->buildUri($endpoint);
        $this->client->send('GET', $uri);
        return $this->client->getBody();
    }

    /**
     * Get Pagination

     * @param string $uri
     */
    protected function getPagination($uri)
    {
        $this->prepareAuth();
        $this->client->send('GET', $uri);
        return $this->client->getBody();
    }

    /**
     * Post

     * @param string $endpoint
     * @param array $params
     */
    protected function post($endpoint, $params = [])
    {
        $this->prepareAuth();
        $uri = $this->zendeskHelper->buildUri($endpoint);
        $this->client->send('POST', $uri, $params);
        return $this->client->getBody();
    }

    /**
     * Oauth Post

     * @param string $endpoint
     * @param array $params
     */
    protected function oauthPost($endpoint, $params = [])
    {
        $uri = $this->zendeskHelper->buildUri($endpoint);
        $this->client->send('POST', $uri, $params);
        return $this->client->getBody();
    }

    /**
     * Put

     * @param string $endpoint
     * @param mixed $params
     */
    protected function put($endpoint, $params)
    {
        $this->prepareAuth();
        $uri = $this->zendeskHelper->buildUri($endpoint);
        $this->client->send('PUT', $uri, $params);
        return $this->client->getBody();
    }

    /**
     * Delete

     * @param string $endpoint
     */
    protected function delete($endpoint)
    {
        $this->prepareAuth();
        $uri = $this->zendeskHelper->buildUri($endpoint);
        $this->client->send('DELETE', $uri);
    }

    /**
     * Get Url
     * @param mixed $object
     * @param mixed $id
     *
     * @return string
     */
    public function getUrl($object, $id)
    {
        return $this->zendeskHelper->getUrl($object, $id);
    }

    /**
     * Prepare Header request once api is available
     */
    private function prepareAuth()
    {
        $this->client->setHeaders(
            [
                'Content-Type' => 'application/json',
                'Authorization' => $this->getAuthorization()
            ]
        );
    }

    /**
     * Get Authorization

     * @return string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getAuthorization()
    {
        $authType = $this->scopeConfig->getValue(self::PATH_AUTH_TYPE, 'store');
        $authorization = '';
        switch ($authType) {
            case 'api_token':
                $storeId = $this->storeManager->getStore()->getId();
                $zdEmail = $this->scopeConfig->getValue(self::PATH_USER_EMAIL, 'stores', $storeId);
                $zdToken = $this->zendeskHelper->getUserApiToken('stores', $storeId);
                $token = "{$zdEmail}/token:{$zdToken}";
                $token = base64_encode($token);
                $authorization = "Basic {$token}";
                break;
            case 'oauth_token':
                $token = $this->zendeskHelper->getToken();
                $authorization = "Bearer {$token}";
                break;
        }
        return $authorization;
    }
}
