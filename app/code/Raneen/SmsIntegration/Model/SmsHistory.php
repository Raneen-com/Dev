<?php
namespace Raneen\SmsIntegration\Model;

class SmsHistory extends \Magento\Framework\Model\AbstractModel {
    const CACHE_TAG = 'id';
    protected function _construct() {
        $this->_init('Raneen\SmsIntegration\Model\ResourceModel\SmsHistory');
    }
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId() ];
    }
}
