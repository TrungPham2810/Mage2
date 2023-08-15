<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 30/04/19
 * Time: 23:44
 */

namespace OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\View\LayoutFactory;

/**
 * Class Add to add form
 * @package OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes
 */
class Add extends Action
{
    /**
     * @var LayoutFactory
     */
    private $layout;
    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * Add constructor.
     * @param Action\Context  $context
     * @param LayoutFactory $layout
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Action\Context $context,
        LayoutFactory $layout,
        JsonFactory $resultJsonFactory
    ) {
        $this->layout = $layout;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $block = $this->layout->create()
            ->createBlock('OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page\NewForm')
            ->setTemplate('OpenTechiz_AdminNote::adminnote/new.phtml')
            ->toHtml();
        $result->setData(['output' => $block]);
        return $result;
    }
}
