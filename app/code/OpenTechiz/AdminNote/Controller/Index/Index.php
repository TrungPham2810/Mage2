<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 09/12/2020
 * Time: 14:58
 */

namespace OpenTechiz\AdminNote\Controller\Index;

use Magento\Store\Model\StoreManagerInterface ;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Framework\Encryption\EncryptorInterface;
//use Magento\Framework\Encryption\CryptFactory;
use OpenTechiz\AdminNote\Block\TestPlugin;
//use OpenTechiz\AdminNote\Block\TestPluginChild as TestPlugin;
use Magento\Catalog\Model\Indexer\Category\Product\Action\Full as CategoryProductActionFull;
use Magento\MessageQueue\Model\Cron\ConsumersRunner;
use Magento\Sales\Model\OrderFactory;
//use OpenTechiz\ProductSlider\Block\TestTranslate as ProductTestTranslate;
//use OpenTechiz\HelloWorld\Block\TestTranslate as HelloWorldTestTranslate;
//use OpenTechiz\AdminNote\Block\TestTranslate as AdminNoteTestTranslate;
//use OpenTechiz\TestModule\Service\ProductFeedService;
//use OpenTechiz\AdminNote\Model\ResourceModel\AdminNoteFactory;
use OpenTechiz\AdminNote\Model\AdminNoteFactory as ModelAdminNoteFactory;
use OpenTechiz\AdminNote\Api\AdminNoteRepositoryInterface;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;
//    protected $order;
//    /**
//     * @var \Magento\Framework\View\Result\PageFactory
//     */
//    protected $storeManager;
//    protected $scopeConfigInterface;
//    protected $layout;
//    protected $encryptorInterface;
//    protected $testPlugin;
//    protected $categoryProductActionFull;
//    protected $consumersRunner;
//    protected $productTestTranslate;
//    protected $helloWorldTestTranslate;
//    protected $adminNoteTestTranslate;
//    protected $productFeedService;
//    protected $adminNoteFactory;
//    protected $modelAdminNoteFactory;
//    protected $adminNoteRepositoryInterface;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
//        StoreManagerInterface $storeManager,
        ScopeConfigInterface $scopeConfigInterface,

//        LayoutInterface $layout,
//        EncryptorInterface $encryptorInterface,
//        TestPlugin $testPlugin,
//        CategoryProductActionFull $categoryProductActionFull,
//        ConsumersRunner $consumersRunner,
//        OrderFactory $order,
//        ProductTestTranslate $productTestTranslate,
//        HelloWorldTestTranslate $helloWorldTestTranslate,
//        AdminNoteTestTranslate $adminNoteTestTranslate,
//        ProductFeedService $productFeedService,
//        AdminNoteFactory $adminNoteFactory,
//        ModelAdminNoteFactory $modelAdminNoteFactory,
//        AdminNoteRepositoryInterface $adminNoteRepositoryInterface,
        \Magento\Framework\View\Result\PageFactory $pageFactory
    ) {
//        $this->categoryProductActionFull = $categoryProductActionFull;
//        $this->storeManager = $storeManager;
        $this->scopeConfigInterface = $scopeConfigInterface;
        $this->_pageFactory = $pageFactory;
//        $this->layout = $layout;
//        $this->encryptorInterface = $encryptorInterface;
//        $this->testPlugin = $testPlugin;
//        $this->consumersRunner = $consumersRunner;
//        $this->order = $order;
//        $this->productTestTranslate = $productTestTranslate;
//        $this->helloWorldTestTranslate = $helloWorldTestTranslate;
//        $this->adminNoteTestTranslate = $adminNoteTestTranslate;
//        $this->productFeedService = $productFeedService;
//        $this->adminNoteFactory = $adminNoteFactory;
//        $this->modelAdminNoteFactory = $modelAdminNoteFactory;
//        $this->adminNoteRepositoryInterface = $adminNoteRepositoryInterface;
        parent::__construct($context);
    }
//    public function init($key)
//    {
//
//        return $this;
//    }
    public function execute()
    {
//        phpinfo();
        $carriers = $this->scopeConfigInterface->getValue(
            'carriers',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            1
        );
//        $media = $this->scopeConfigInterface->getValue('web/unsecure/base_media_url');
//        var_dump($carriers);
//        die();

//        $model = $this->adminNoteRepositoryInterface->getById(3);
//        $model->addData(['note' => 'xxxxx']);
//        $this->adminNoteRepositoryInterface->save($model);
//        $model = $this->modelAdminNoteFactory->create();
//        $xxx = $this->adminNoteFactory->create()->load($model, 'xxxxxxx','note');
//        $yy = 5;
//        die();
//        $x = 2;
//        $y = $x++;
//        echo $y;
//        echo "<br>";
//        echo $x;
//        die();
//        $xx =  $this->productFeedService->getProductFeedList();
//        die();
//        $message = '{0, select, f {She} m {He} other {It}} went to the store.';
//        $fmt = new \MessageFormatter('fr_FR', $message);
//        print $fmt->format(array('f')) . "\n";
//        print $fmt->format(array('m')) . "\n";
//        print $fmt->format(array('Unknown')) . "\n";
//        echo __('{0, select, f {She} m {He} other {It}} went to the store.', ['f']);
//        echo __('The value of is {0, choice, 0 #less 12| 12 #between 12 and 32| 32 #more than 32}', ['SomeAnotherKey' => -1]);
//        echo __('Please enter {somekey} words or less', [1000]);
//        echo __('{width}^{height} px', ['width'=> 10, 'height' => 20]);
//        echo "<br>";
//        echo __('toi ten la %1 nam nay toi %2 tuoi', 'Trung', 26);
//        echo "<br>";
//        echo __('ok di em %1', 'xxxxxx');
//
//        echo "<br>";
//        echo $this->adminNoteTestTranslate->getTranslate();
//        echo "<br>";
//        echo $this->productTestTranslate->getTranslate();
//        echo "<br>";
//        echo $this->helloWorldTestTranslate->getTranslate();
//        die();
//        $xx = $this->storeManager->getStore();
//        echo 44444;
//        $order = $this->order->create()->load(5);
//        $orderItems = $order->getItems();
//        foreach ($orderItems as $orderItem) {
//            $orderItem->setQtyOrdered(1);
//            $orderItem->save();
//        }
//        $order->save();
//        $xx = time();
//        $aa = time();
//        die();
//        echo 1111;
//        die();
//        $this->consumersRunner->run();
//        $xx = $this->layout->createBlock(\OpenTechiz\AdminNote\Block\TestPlugin::class);
//        echo $this->testPlugin->testPlugin();
//        die();
//        $store = $this->storeManager->getStore(2);
//        var_dump($this->categoryProductActionFull->testOverride() );
//        var_dump($this->categoryProductActionFull->testPlugin2($store)->__toString() );
//        echo $this->testPlugin->testPlugin(111);
//        echo $this->testPlugin->testOverride();
//        return $this->_pageFactory->create();
//        echo $this->testPlugin->testPlugin('origin param');
//        die();
//        $key = 'testxxxxx!$5ty&';
//        $handler = mcrypt_module_open(MCRYPT_BLOWFISH, '', MCRYPT_MODE_ECB, '');
//        if (MCRYPT_MODE_CBC == MCRYPT_MODE_ECB) {
//            $initVector = substr(
//                md5(mcrypt_create_iv (mcrypt_enc_get_iv_size($handler), MCRYPT_RAND)),
//                - mcrypt_enc_get_iv_size($handler)
//            );
//        } else {
//            $initVector = mcrypt_create_iv (mcrypt_enc_get_iv_size($handler), MCRYPT_RAND);
//
//        }
//        $initVector = false;
//
//        $maxKeySize = mcrypt_enc_get_key_size($handler);
//
//        if (strlen($key) > $maxKeySize) { // strlen() intentionally, to count bytes, rather than characters
//            $this->setHandler(null);
//        }
//
//        mcrypt_generic_init($handler, $key, $initVector);
////        'Zcuh1D+Dcw4=';
//        echo $testCrypt = base64_encode(mcrypt_generic($handler, $key));
//        echo "<br/>";
//        echo $testDecrypt = str_replace("\x0", '', trim(mdecrypt_generic($handler, base64_decode((string)'mKfGgveNwwZ5/3mYJXypP7sppXdrLNL4j/Tzr6/2ad4='))));
//
//
////        echo "<br/>";
//        echo $this->encryptorInterface->decrypt('0:3:UVTH2KDBri78aiSdq3vfUWgeI+XWYJbbzcOED/aFzfi3xg==');
//        die();
////        base64_decode();
//        echo base64_decode($this->scopeConfigInterface->getValue('recaptcha_backend/type_recaptcha/private_key'));
//        echo "<br/>";
//        echo base64_decode($this->scopeConfigInterface->getValue('recaptcha_backend/type_invisible/private_key'));
//        die();
//        $testCms = $this->layout
//            ->createBlock(\Magento\Cms\Block\Block::class)
//            ->setBlockId('test-url-category')
//            ->toHtml();
//
//        echo $testCms;
//        die();
//        $url = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
//        echo $url;
//        echo "<br/>";
//        $media = $this->scopeConfigInterface->getValue('web/unsecure/base_media_url');
//        echo $media;
//        echo "<br/>";

//        die();
//        $this->_eventManager->dispatch('test_exception_event', ['data' => 1]);
//
        $resultPage = $this->_pageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('AdminNote Index'));
        return $resultPage;
    }
}
