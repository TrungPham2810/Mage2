<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
/**
 * @documentation: https://support.zendesk.com/hc/en-us/articles/203663836-Using-OAuth-authentication-with-your-application
 */
namespace Wagento\Zendesk\Helper\Api;

use Wagento\Zendesk\Helper\Api\ErrorHandler\Connector as ErrorHandlerConnector;

/**
 * This class will be used once, justo get access token
 *
 * Class Connector
 */
class Connector extends \Wagento\Zendesk\Helper\Api\AbstractApi
{
    public const OAUTH_VALIDATION = '/api/v2/users/me/oauth/clients.json';

    /**
     * Zendesk OAUTH constants
     */
    public const OAUTH_NEW = '/oauth/authorizations/new';
    public const GET_TOKEN = '/oauth/tokens';
    public const HANDLER = 'zendesk';

    /**
     * Get Auth Url.
     *
     * @param null $options
     * @return string
     */
    public function getAuthUrl()
    {
        $options = [
            'response_type' => 'code',
            'redirect_uri' => $this->_getUrl(self::HANDLER),
            'client_id' => $this->zendeskHelper->getClientId(),
            'scope' => 'read write',
            'state' => null,
        ];

        $oAuthUrl = $this->zendeskHelper->buildUri(self::OAUTH_NEW) . '?';
        $oAuthUrl .= http_build_query(array_filter($options));

        return $oAuthUrl;
    }

    /**
     * Generate Oauth token.
     *
     * @param mixed $code
     * @param mixed $token
     * @return bool
     */
    public function generateToken($code, &$token = null)
    {
        // Fetch access_token
        $params = [
            'code' => $code,
            'client_id' => $this->zendeskHelper->getClientId(),
            'client_secret' => $this->zendeskHelper->getSecret(),
            'grant_type' => 'authorization_code',
            'scope' => 'read write',
            'redirect_uri' => $this->_getUrl(self::HANDLER)
        ];
        try {
            // parrams needs to be an array
            $jsonResponse = $this->oauthPost(self::GET_TOKEN, $params);
            $response = json_decode($jsonResponse, true);
            if (isset($response['access_token'])) {
                $token = $response['access_token'];
                $this->zendeskHelper->saveStoreConfig(ErrorHandlerConnector::XML_PATH_ERROR, ErrorHandlerConnector::NO_ERROR);
                return true;
            }
        } catch (\Exception $exception) {
            $response['error'] = $exception->getMessage();
        }
        $this->zendeskHelper->saveStoreConfig(ErrorHandlerConnector::XML_PATH_ERROR, ErrorHandlerConnector::WORNG_FIELDS_VALUES_ERROR);
        return false;
    }

    /**
     * Validates configuration.
     *
     * @param mixed $config
     * @param null $clientId
     * @return bool
     * @internal param array $configs
     */
    public function validateConfig($config)
    {
        if (isset($config['client_id'], $config['subdomain'], $config['client_secret'])) {
            $scope = $config['scope'];
            $scopeId = $config['scopeId'];

            $this->zendeskHelper->setClientId($config['client_id'], $scope, $scopeId);
            $this->zendeskHelper->setSubdomain($config['subdomain'], $scope, $scopeId);
            $this->zendeskHelper->setSecret($config['client_secret'], $scope, $scopeId);

            $this->zendeskHelper->cleanCacheConfig();
            return true;
        }
        $this->zendeskHelper->saveStoreConfig(ErrorHandlerConnector::XML_PATH_ERROR, ErrorHandlerConnector::EMPTY_FIELDS_ERROR);
        return false;
    }

    /**
     * Save Token.
     *
     * @param string $token
     */
    public function saveToken($token)
    {
        $this->zendeskHelper->setToken($token);
        $this->zendeskHelper->cleanCacheConfig();
    }

    /**
     * Validate Configured Connection
     *
     * @return bool
     */
    public function validateConfiguredConnection()
    {
        $response = $this->get(self::OAUTH_VALIDATION);
        $data = json_decode($response, true);
        return isset($data['clients']) && $data['clients'] > 0 ? true : false;
    }

    /**
     * Get Configured Values

     * @return array
     */
    public function getConfiguredValues()
    {
        return [
            'client_id' => $this->zendeskHelper->getClientId(),
            'subdomain' => $this->zendeskHelper->getSubdomain(),
            'client_secret' => $this->zendeskHelper->getSecret(),
        ];
    }
}
