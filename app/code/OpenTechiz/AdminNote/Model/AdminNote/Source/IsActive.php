<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 26/04/2019
 * Time: 09:16
 */

namespace OpenTechiz\AdminNote\Model\AdminNote\Source;

use OpenTechiz\AdminNote\Model\AdminNote;

class IsActive implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var AdminNote
     */
    protected $adminNote;

    /**
     * Constructor
     *
     * @param AdminNote $adminNote
     */
    public function __construct(AdminNote $adminNote)
    {
        $this->adminNote = $adminNote;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->adminNote->getAvailableStatuses();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
