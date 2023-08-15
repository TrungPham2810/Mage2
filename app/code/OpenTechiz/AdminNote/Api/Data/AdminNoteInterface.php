<?php
/**
 * Created by PhpStorm.
 * User: trungpham
 * Date: 25/04/2019
 * Time: 18:33
 */

namespace OpenTechiz\AdminNote\Api\Data;

use Magento\Framework\Api\ExtensibleDataInterface;

interface AdminNoteInterface extends ExtensibleDataInterface
{
    public function getAvailableStatuses();
    public function isHidden();
    public function getTypes();
    public function getNameAuthor($id);
    public function isEditable();
    public function isDeletable();
}
