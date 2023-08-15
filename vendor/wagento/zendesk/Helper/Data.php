<?php
/**
 * Copyright Wagento Creative LLC ©, All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Wagento\Zendesk\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * GENERAL ZENDESK CONSTANTS
     */
    public const PROTOCOL = 'https://';

    public const DOMAIN = '.zendesk.com';

    /**
     * MAGENTO CONFIG PATH CONSTANTS
     */
    public const PATH_CLIENT_ID = 'zendesk/config/client_id';
    public const PATH_SUBDOMAIN = 'zendesk/config/zendesk_subdomain';
    public const PATH_SECRET = 'zendesk/config/secret';
    public const PATH_TOKEN = 'zendesk/config/token';
    public const PATH_USER_API_TOKEN = 'zendesk/config/api_token';
    public const PATH_ORDER_FIELD = 'zendesk/ticket/order_field_id';

    /**
     * @var null
     */
    private $subdomain = null;

    /**
     * @var null
     */
    private $client_id = null;

    /**
     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    private $encryptor;
    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $configWriter;
    /**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    private $typeList;

    /**
     * Data constructor.

     * @param Context $context
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     * @param \Magento\Framework\App\Config\Storage\WriterInterface $configWriter
     * @param \Magento\Framework\App\Cache\TypeListInterface $typeList
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor,
        \Magento\Framework\App\Config\Storage\WriterInterface $configWriter,
        \Magento\Framework\App\Cache\TypeListInterface $typeList
    ) {

        parent::__construct($context);
        $this->encryptor = $encryptor;
        $this->configWriter = $configWriter;
        $this->typeList = $typeList;
    }

    /**
     * Get Client Id

     * @return string | null
     */
    public function getClientId()
    {
        if (is_null($this->client_id)) {
            $this->client_id = $this->scopeConfig->getValue(self::PATH_CLIENT_ID);
        }
        return $this->client_id;
    }

    /**
     * Set Client Id

     * @param mixed $value
     * @param mixed $scope
     * @param mixed $scopeId
     */
    public function setClientId($value, $scope, $scopeId)
    {
        $this->client_id = $value;
        $this->configWriter->save(self::PATH_CLIENT_ID, $value, $scope, $scopeId);
    }

    /**
     * Get Secret

     * @return string
     */
    public function getSecret()
    {
        $secret = $this->scopeConfig->getValue(self::PATH_SECRET);
        return htmlspecialchars($this->encryptor->decrypt($secret), ENT_COMPAT);
    }

    /**
     * Get Subdomain

     * @return string
     */
    public function getSubdomain()
    {
        if (is_null($this->subdomain)) {
            $this->subdomain = $this->scopeConfig->getValue(self::PATH_SUBDOMAIN);
        }
        return $this->subdomain;
    }

    /**
     * Get Token

     * @return string
     */
    public function getToken()
    {
        $token = $this->scopeConfig->getValue(self::PATH_TOKEN);
        return htmlspecialchars($this->encryptor->decrypt($token), ENT_COMPAT);
    }

    /**
     * Get User Api Token

     * @return string
     */
    public function getUserApiToken($scopeType = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeCode = null)
    {
        $token = $this->scopeConfig->getValue(self::PATH_USER_API_TOKEN, $scopeType, $scopeCode);
        return htmlspecialchars($this->encryptor->decrypt($token), ENT_COMPAT);
    }

    /**
     * Get Order Field

     * @return string
     */
    public function getOrderField()
    {
        return $this->scopeConfig->getValue(
            self::PATH_ORDER_FIELD,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Set Subdomain

     * @param mixed $value
     * @param string $scope
     * @param int $scopeId
     */
    public function setSubdomain($value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0)
    {
        $this->subdomain = $value;
        $this->configWriter->save(self::PATH_SUBDOMAIN, $value, $scope, $scopeId);
    }

    /**
     * Set Secret

     * @param mixed $value
     * @param string $scope
     * @param int $scopeId
     */
    public function setSecret($value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0)
    {
        $encryptedSecret = $this->encryptor->encrypt($value);
        $this->configWriter->save(self::PATH_SECRET, $encryptedSecret, $scope, $scopeId);
    }

    /**
     * Build Uri

     * @param mixed $endpoint
     * @return string
     */
    public function buildUri($endpoint)
    {
        return $this->getDomain() . $endpoint;
    }

    /**
     * Get Domain

     * @param bool $excludeProtocol
     * @return string
     */
    public function getDomain($excludeProtocol = false)
    {
        if (is_null($this->subdomain)) {
            $this->subdomain = $this->scopeConfig->getValue(self::PATH_SUBDOMAIN, 'store');
        }
        $protocol = $excludeProtocol ? '' : self::PROTOCOL;
        return $protocol . $this->subdomain . self::DOMAIN;
    }

    /**
     * Get Support Email

     * @param mixed $scope
     * @param mixed $storeCode
     * @return string
     */
    public function getSupportEmail($scope, $storeCode)
    {
        return 'support@' . $this->getDomain(true);
    }

    /**
     * Set Token

     * @param mixed $value
     * @param string $scope
     * @param int $scopeId
     */
    public function setToken($value, $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0)
    {
        $encryptedToken = $this->encryptor->encrypt($value);
        $this->configWriter->save(self::PATH_TOKEN, $encryptedToken, $scope, $scopeId);
    }

    /**
     * Revoke Token

     * @param mixed $value
     * @param string $scope
     * @param int $scopeId
     */
    public function revokeToken($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT, $scopeId = 0)
    {
        $this->configWriter->save(self::PATH_TOKEN, null, $scope, $scopeId);
    }

    /**
     * Get Url

     * @param mixed $object
     * @param mixed $id
     * @param mixed $format
     *
     * @return string
     */
    public function getUrl($object = '', $id = null, $format = 'old')
    {

        $protocol = 'https://';

        // get domain with protocol
        $domain = $this->getDomain(true);
        $root = ($format === 'old') ? '' : '/agent';

        $pathBase = $protocol . $domain . $root;

        // objects type ticket or user
        switch ($object) {
            case '':
                return $pathBase;
            case 'ticket':
                return $pathBase . '/tickets/' . $id;
            case 'user':
                return $pathBase . '/users/' . $id;
            case 'raw':
                return $pathBase . $domain . '/' . $id;
        }
    }

    /**
     * Clean Cache Config
     */
    public function cleanCacheConfig()
    {
        $this->typeList->cleanType('config');
    }

    /**
     * Save Store Config

     * @param mixed $path
     * @param mixed $value
     */
    public function saveStoreConfig($path, $value)
    {
        $this->configWriter->save($path, $value);
    }
}
