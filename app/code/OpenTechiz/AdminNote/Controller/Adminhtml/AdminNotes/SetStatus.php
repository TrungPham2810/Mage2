<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 07/05/2019
 * Time: 16:22
 */

namespace OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\Result\JsonFactory;
use OpenTechiz\AdminNote\Model\AdminNoteFactory;

/**
 * Class SetStatus
 * @package OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes
 */
class SetStatus extends \Magento\Backend\App\Action
{
    /**
     * @var AdminNoteFactory
     */
    protected $adminNote;
    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * SetStatus constructor.
     * @param Action\Context $context
     * @param AdminNoteFactory $adminNote
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Action\Context $context,
        AdminNoteFactory $adminNote,
        JsonFactory $resultJsonFactory
    ) {
        $this->adminNote = $adminNote;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $result->setData(['error' => false ]);
        $request = $this->getRequest();
        $noteId = $request->getParam('note_id');
        $status = $request->getParam('status', 0);
        $user_id = $request->getParam('user_id');
        if (!empty($noteId) && !empty($user_id)) {
            try {
                $model = $this->adminNote->create();
                $model->load($noteId);
                $model->updateStatus($status);
                $result->setData(['error' => true ]);
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }
        return $result;
    }
}
