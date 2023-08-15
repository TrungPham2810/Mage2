<?php

namespace OpenTechiz\AdminNote\Model;

use Exception;
use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Api\AttributeValueFactory;
use Magento\Framework\Api\ExtensionAttributesFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\User\Model\UserFactory;
use OpenTechiz\AdminNote\Api\Data\AdminNoteInterface;
use Magento\Framework\Model\AbstractExtensibleModel;

/**
 * Class AdminNote
 * @package OpenTechiz\AdminNote\Model
 */
class AdminNote extends AbstractExtensibleModel implements AdminNoteInterface
{
    const STATUS_VISIBLE = 0;

    const STATUS_HIDE = 1;

    /**
     * authSession
     *
     * @var Session
     */
    protected $authSession;
    /**
     * @var RequestInterface
     */
    protected $_request;

    /**
     * @var UserFactory
     */
    protected $_userFactory;
    /**
     * @var NoteUserRelationFactory
     */
    protected $noteUserRelation;

   public function __construct(
       Context $context,
       \Magento\Framework\Registry $registry,
       ExtensionAttributesFactory $extensionFactory,
       AttributeValueFactory $customAttributeFactory,
       AbstractResource $resource = null,
       \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
       Session $authSession,
       UserFactory $userFactory,
       RequestInterface $request,
       NoteUserRelationFactory $noteUserRelation,
       array $data = []
   ) {
               $this->authSession = $authSession;
        $this->_userFactory = $userFactory;
        $this->_request = $request;
        $this->noteUserRelation = $noteUserRelation;
       parent::__construct($context, $registry, $extensionFactory, $customAttributeFactory, $resource, $resourceCollection, $data);
   }
//    public function __construct(
//        Context $context,
//        Registry $registry,
//        AbstractResource $resource = null,
//        AbstractDb $resourceCollection = null,
//        Session $authSession,
//        UserFactory $userFactory,
//        RequestInterface $request,
//        NoteUserRelationFactory $noteUserRelation,
//        array $data = []
//    ) {
//        $this->authSession = $authSession;
//        $this->_userFactory = $userFactory;
//        $this->_request = $request;
//        $this->noteUserRelation = $noteUserRelation;
//        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
//    }

    protected function test()
    {

    }
    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init('OpenTechiz\AdminNote\Model\ResourceModel\AdminNote');
    }

    /**
     * get value of status and key
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_VISIBLE=>__('Visible'), self::STATUS_HIDE=>__('Hidden')];
    }

    /**
     * @return bool
     */
    public function isHidden()
    {
        return $this->getStatus() > 0;
    }

    /**
     * @return array
     */
    public function getTypes()
    {
        return [
            'note'     => 'Note',
            'comment'  => 'Comment',
            'message'  => 'Message',
            'warning'  => 'Warning',
            'question' => 'Question',
        ];
    }

    /**
     * load status for table me_admin_note_user_relation follow current user_id
     * @return $this
     * @throws Exception
     */
    public function loadStatus()
    {
        $user_id = $this->authSession->getUser()->getUserId();
        $note_id = $this->getNoteId();
        $data = $this->noteUserRelation->create()->getCollection()->addFieldToFilter('user_id', ['eq' =>$user_id])
            ->addFieldToFilter('note_id', ['eq' =>$note_id]);
        $count = $data->count();
        if ($count > 0) {
            foreach ($data as $item) {
                $status = $item->getStatus();
                $this->setData('status', $status);
            }
        } else {
            $this->setData('status', 0);
            $this->createUserRelation($user_id, $note_id);
        }
        return $this;
    }

    /**
     * @return array|mixed|null
     */
    public function getNoteId()
    {
        return $this->getData('note_id');
    }

    /**
     * @param $note_id
     * @return array|mixed|null
     */
    public function setNoteId($note_id)
    {
        return $this->setData('note_id', $note_id);
    }

    /**
     * add data for table me_admin_note_user_relation when create new note page or
     * first time user go to path have note page
     *
     * @param $user_id
     * @param $note_id
     * @throws Exception
     */
    public function createUserRelation($user_id, $note_id)
    {
        $model = $this->noteUserRelation->create();
        $model->addData([
            'user_id'          => $user_id,
            'note_id'          => $note_id
        ]);
        $model->save();
    }

    /**
     * @param $status
     * @return $this
     * @throws Exception
     */
    public function updateStatus($status)
    {
        $note_id = $this->getNoteId();
        $user_id = $this->authSession->getUser()->getUserId();
        if (!empty($user_id)) {
            $data =  $this->noteUserRelation->create()->getCollection()->addFieldToFilter('user_id', ['eq' =>$user_id])
                ->addFieldToFilter('note_id', ['eq' =>$note_id]);
            foreach ($data as $item) {
                $id = $item->getId();
                $model = $this->noteUserRelation->create()->load($id);
                $model->setData('status', $status);
                $model->save();
            }
        }
        return $this;
    }

    /**
     * @param $id
     * @return string
     */
    public function getNameAuthor($id)
    {
        $user = $this->_userFactory->create()->load($id);
        return $user->getFirstName() . " " . $user->getLastName();
    }

    /**
     * @return bool
     */
    public function isEditable()
    {
        if ($this->authSession->getUser()->getUserId() == $this->getCreatedBy() || $this->authSession->isAllowed('OpenTechiz_AdminNote::edit')) {
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function isDeletable()
    {
        if ($this->authSession->getUser()->getUserId() == $this->getCreatedBy() || $this->authSession->isAllowed('OpenTechiz_AdminNote::delete')) {
            return true;
        }
        return false;
    }
}
