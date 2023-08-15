<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 25/04/2019
 * Time: 16:34
 */

namespace OpenTechiz\AdminNote\Model\AdminNote\Source;

use Magento\User\Model\UserFactory;
use OpenTechiz\AdminNote\Model\AdminNoteFactory;

/**
 * Class Author
 * @package OpenTechiz\AdminNote\Model\AdminNote\Source
 */
class Author implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var AdminNoteFactory
     */
    protected $adminNote;
    /**
     * @var UserFactory
     */
    protected $userFactory;

    /**
     * Author constructor.
     * @param AdminNoteFactory $adminNote
     * @param UserFactory $userFactory
     */
    public function __construct(
        AdminNoteFactory $adminNote,
        UserFactory $userFactory
    ) {
        $this->adminNote = $adminNote;
        $this->userFactory = $userFactory;
    }
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $data = $this->userFactory->create()->getCollection()->addFieldToSelect('user_id')->getColumnValues('user_id');

        foreach ($data as $value) {
            $userInfo = $this->userFactory->create()->load($value);
            $userName = $userInfo->getUserName();
            $options[] = [
                'label' => $userName,
                'value' => $value,
            ];
        }
        return $options;
    }
}
