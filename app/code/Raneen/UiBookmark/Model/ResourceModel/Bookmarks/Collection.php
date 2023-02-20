<?php
namespace Raneen\UiBookmark\Model\ResourceModel\Bookmarks;

use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;

use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult;
use Psr\Log\LoggerInterface as Logger;
use Raneen\UiBookmark\Helper\Data;

class Collection extends SearchResult
{
    protected $scopeConfig;

    protected $authSesssion;
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable,
        $resourceModel = null,
        $identifierName = null,
        $connectionName = null
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
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $user = $objectManager->get('Magento\Backend\Model\Auth\Session')->getUser();
        $roles = explode(",", $objectManager->get('Raneen\UiBookmark\Helper\Data')->getGeneralConfig('enable'));

        $this->addFilterToMap(
            'username',
            'admin_user.username'
        );
        $this->addFilterToMap(
            'email',
            'admin_user.email'
        );

        $this->getSelect()->joinLeft(
            'admin_user',
            '`admin_user`.user_id =`main_table`.user_id',
            ["username","email"]
        );

        if (!in_array($user->getRole()->getData()['role_id'], $roles)) {
            $this->getSelect()->where("`main_table`.user_id = " . $user->getId());
        }
        parent::_initSelect();
    }
}
