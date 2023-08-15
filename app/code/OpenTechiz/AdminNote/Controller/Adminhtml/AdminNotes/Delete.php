<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 07/05/2019
 * Time: 16:22
 */

namespace OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes;

use Magento\Backend\App\Action;
use OpenTechiz\AdminNote\Model\AdminNoteFactory;

/**
 * Class Delete
 * @package OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes
 */
class Delete extends \Magento\Backend\App\Action
{
    /**
     * @var AdminNoteFactory
     */
    protected $adminNote;

    /**
     * Delete constructor.
     * @param Action\Context $context
     * @param AdminNoteFactory $adminNote
     */
    public function __construct(
        Action\Context $context,
        AdminNoteFactory $adminNote
    ) {
        $this->adminNote = $adminNote;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        $request = $this->getRequest();
        $noteId = $request->getParam('note_id');
        if (!empty($noteId)) {
            try {
                $model = $this->adminNote->create();
                $model->load($noteId);
                if ($model->isDeletable()) {
                    $model->delete();
                }
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        } else {
            $this->messageManager->addError(__('We can\'t find a post to delete.'));
        }
    }
}
