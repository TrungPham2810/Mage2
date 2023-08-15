<?php

namespace Wagento\Zendesk\Controller\ViewOrder;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Backend\Model\UrlInterface
     */
    private $url;

    /**
     * EncryptorInterface

     * @var \Magento\Framework\Encryption\EncryptorInterface
     */
    private $encryptor;

    /**
     * Index construct

     * @param Context $context
     * @param \Magento\Backend\Model\UrlInterface $url
     * @param \Magento\Framework\Encryption\EncryptorInterface $encryptor
     */
    public function __construct(
        Context $context,
        \Magento\Backend\Model\UrlInterface $url,
        \Magento\Framework\Encryption\EncryptorInterface $encryptor
    ) {
        parent::__construct($context);
        $this->url = $url;
        $this->encryptor = $encryptor;
    }

    /**
     * Index execute

     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        $redirect = $this->resultRedirectFactory->create();
        $redirect->setPath('/');

        $b64h = $this->getRequest()->getParam('h');
        $eh = base64_decode($b64h);
        $h = $this->encryptor->decrypt($eh);
        $hdata = explode('|', $h);

        if (count($hdata) == 2) {
            if (isset($hdata[0]) && in_array($hdata[0], ['orderId'])) {
                if (isset($hdata[1]) && is_numeric($hdata[1])) {
                    $orderId = $hdata[1];
                    $url = $this->url->getUrl('sales/order/view', ['order_id' => $orderId]);
                    $redirect->setPath($url);
                }
            }
        }
        return $redirect;
    }
}
