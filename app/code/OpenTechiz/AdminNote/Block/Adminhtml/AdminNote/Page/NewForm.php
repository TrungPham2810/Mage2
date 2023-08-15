<?php
/**
 * Created by PhpStorm.
 * @package OpenTechiz
 * @subpackage AdminNote
 * @author trungpham
 * @copyright OpenTechiz
 * Date: 02/05/2019
 * Time: 10:07
 */

namespace OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\Element\Template;
use OpenTechiz\AdminNote\Helper\Data;
use OpenTechiz\AdminNote\Model\AdminNote;

class NewForm extends Template
{
    /**
     * @var AdminNote
     */
    protected $adminNote;
    /**
     * @var Data
     */
    protected $helperData;
    /**
     * authSession
     *
     * @var \Magento\Backend\Model\Auth\Session
     */
    protected $authSession;

    /**
     * NewForm constructor.
     * @param Template\Context $context
     * @param AdminNote $adminNote
     * @param Data $helpData
     * @param Session $authSession
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        AdminNote $adminNote,
        Data $helpData,
        Session $authSession,
        array $data = []
    ) {
        $this->adminNote = $adminNote;
        $this->helperData = $helpData;
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

    /**
     * @return array
     */
    public function getTypes()
    {
        return $this->adminNote->getTypes();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->helperData->getCurrentPathId();
    }
}
