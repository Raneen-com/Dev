<?php

namespace Raneen\SmsIntegration\Model;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $loadedData;
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Raneen\SmsIntegration\Model\ResourceModel\SmsIntegrations\CollectionFactory $SmsCollection,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $SmsCollection->create();
        $this->_storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $job_data) {
            $this->loadedData[$job_data->getId()] = $job_data->getData();
        }

        return $this->loadedData;
    }

}
