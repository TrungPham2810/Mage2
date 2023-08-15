<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 03/05/2019
 * Time: 16:36
 */

namespace OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\Element\Template;

/**
 * Class Note
 * @package OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page
 */
class Note extends Template
{
    /**
     * authSession
     *
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    /**
     * Note constructor.
     * @param Template\Context $context
     * @param Session $authSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        Session $authSession,
        array $data = []
    ) {

        $this->authSession = $authSession;
        parent::__construct($context, $data);
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->authSession->getUser()->getUserId();
    }
}
