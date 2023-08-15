<?php
/**
 * Created by PhpStorm.
 *
 * @package    OpenTechiz
 * @subpackage AdminNote
 * @author     trungpham
 * @copyright  OpenTechiz
 * Date: 26/04/2019
 * Time: 11:18
 */

namespace OpenTechiz\AdminNote\Block\Adminhtml\AdminNote;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\View\LayoutFactory;
use OpenTechiz\AdminNote\Helper\Data;
use OpenTechiz\AdminNote\Model\AdminNoteFactory;

/**
 * Class Page
 *
 * @package OpenTechiz\AdminNote\Block\Adminhtml\AdminNote
 */
class Page extends \Magento\Backend\Block\Template
{
    /**
     * @var AdminNoteFactory
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
     * @var LayoutFactory
     */
    private $layout;

    public function __construct(
        AdminNoteFactory $adminNote,
        Data $helpData,
        Session $authSession,
        \Magento\Backend\Block\Template\Context $context,
        LayoutFactory $layout,
        array $data = []
    ) {
        $this->adminNote = $adminNote;
        $this->helperData = $helpData;
        $this->authSession = $authSession;
        $this->layout = $layout;
        parent::__construct($context, $data);
    }

    /**
     * Get list record have path_id similar current url
     *
     * @return \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
     */
    public function getNotes()
    {
        $model = $this->adminNote->create()->getCollection()->addFieldToFilter('path_id', $this->getPathId());
        return $model;
    }

    /**
     * render file note.phtml
     *
     * @param  $note
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getNoteHtml($note)
    {
        return $this->getLayout()->createBlock('OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page\Note')
            ->setTemplate('OpenTechiz_AdminNote::adminnote/note.phtml')
            ->setNote($note)
            ->toHtml();
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->authSession->getUser()->getUserId();
    }

    /**
     * @return string
     */
    public function getPathId()
    {
        return $this->helperData->getCurrentPathId();
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->helperData->getCurrentPath();
    }

    /**
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('adminnotes/adminnotes/save');
    }

    /**
     * @return string
     */
    public function getNewUrl()
    {
        return $this->getUrl('adminnotes/adminnotes/add');
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('adminnotes/adminnotes/delete');
    }

    /**
     * @return string
     */
    public function getStatusUrl()
    {
        return $this->getUrl('adminnotes/adminnotes/setstatus');
    }

    /**
     *  check current user have role write
     *
     * @return boolean
     */
    public function canWrite()
    {
        return true;
    }
}
