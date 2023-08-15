<?php


namespace OpenTechiz\AdminNote\Api\Data;


interface AdminNoteSearchResultInterface
{

    public function getItems();

    public function setItems(array $items);
}
