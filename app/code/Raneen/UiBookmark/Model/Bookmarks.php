<?php
namespace Raneen\UiBookmark\Model;

class Bookmarks extends \Magento\Ui\Model\Bookmark {
//    const CACHE_TAG = 'ktree_ticketingsystem_ticket';
//    protected $_cacheTag = 'ktree_ticketingsystem_ticket';
//    protected $_eventPrefix = 'ktree_ticketingsystem_ticket';

    protected function _construct() {
        $this->_init('Raneen\UiBookmark\Model\ResourceModel\Bookmarks');
    }

//    public function getIdentities() {
//        return [self::CACHE_TAG . '_' . $this->getId() ];
//    }
//    public function getDefaultValues() {
//        $values = [];
//        return $values;
//    }
}
