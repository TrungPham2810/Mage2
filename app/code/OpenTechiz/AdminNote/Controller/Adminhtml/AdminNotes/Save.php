<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 02/05/2019
 * Time: 12:01
 */
namespace OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\LayoutFactory;
use OpenTechiz\AdminNote\Model\AdminNoteFactory;

/**
 * Class Save
 * @package OpenTechiz\AdminNote\Controller\Adminhtml\AdminNotes
 */
class Save extends Action
{
    /**
     * @var AdminNoteFactory
     */
    protected $adminNote;
    /**
     * @var LayoutFactory
     */
    private $layout;
    /**
     * @var JsonFactory
     */
    protected $_resultJsonFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param AdminNoteFactory $adminNote
     * @param LayoutFactory $layout
     * @param JsonFactory $resultJsonFactory
     */
    public function __construct(
        Action\Context $context,
        AdminNoteFactory $adminNote,
        LayoutFactory $layout,
        JsonFactory $resultJsonFactory
    ) {
        $this->adminNote = $adminNote;
        $this->layout = $layout;
        $this->_resultJsonFactory = $resultJsonFactory;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Json|ResultInterface
     */
    public function execute()
    {
        $result = $this->_resultJsonFactory->create();
        $request = $this->getRequest();
        try {
            if ($request->getParam('note_id')) {
                $update = $this->adminNote->create();
                $update->load($request->getParam('note_id'));
                $update->setData('title', $request->getParam('title', null));
                $update->setData('note', $request->getParam('note', null));
                $update->setData('type', $request->getParam('type', null));
                $update->save();
                $result->setData(['error' => true ]);
            } else {
                $model = $this->adminNote->create();
                $model->addData([
                    'path_id'          => $request->getParam('path_id', null),
                    'path'             => $request->getParam('path', null),
                    'title'            => $request->getParam('title', null),
                    'note'             => $request->getParam('note', null),
                    'type'             => $request->getParam('type', null),
                    'created_by'       => $request->getParam('user_id', null),
                ]);
                $model->save();
                $noteId = $model->getNoteId();
                $note = $model->load($noteId);
                $user_id = $note->getCreatedBy();
                $note->createUserRelation($user_id, $noteId);
                $note->setData('status', 0);
                $block = $this->layout->create()
                    ->createBlock('OpenTechiz\AdminNote\Block\Adminhtml\AdminNote\Page\Note')
                    ->setTemplate('OpenTechiz_AdminNote::adminnote/note.phtml')
                    ->setNote($note)
                    ->toHtml();
                $result->setData([
                    'error' => true,
                    'output' => $block
                ]);
            } //end if
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
            $result->setData(['error' => false]);
        } //end try
        return $result;
    }
}
