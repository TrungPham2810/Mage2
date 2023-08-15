<?php


namespace OpenTechiz\AdminNote\Model;

use OpenTechiz\AdminNote\Model\ResourceModel\AdminNote\CollectionFactory;

class DataProvider  extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $employeeCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $noteCollectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $noteCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $note) {
            $this->_loadedData[$note->getNoteId()]['tab1']= $note->getData();
            $this->_loadedData[$note->getNoteId()]['tab2']= $note->getData();
        }
        return $this->_loadedData;
    }
}
