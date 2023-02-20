<?php

namespace Raneen\SmsIntegration\Model\ResourceModel\SmsIntegrations;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;

class Collection extends SearchResult
{
    protected $scopeConfig;

    public function __construct(
        EntityFactory $entityFactory,
        Logger        $logger,
        FetchStrategy $fetchStrategy,
        EventManager  $eventManager,
        $mainTable,
        $resourceModel = null,
        $identifierName = null,
        $connectionName = null,
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $mainTable,
            $resourceModel,
            $identifierName,
            $connectionName
        );
    }

    protected function _initSelect()
    {
        parent::_initSelect();
    }
}
