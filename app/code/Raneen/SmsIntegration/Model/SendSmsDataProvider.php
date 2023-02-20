<?php

namespace Raneen\SmsIntegration\Model;

class SendSmsDataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
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
        return [];
    }

}
