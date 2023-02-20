<?php
namespace Raneen\SmsIntegration\Model;

class SmsIntegrations extends \Magento\Framework\Model\AbstractModel {
    const CACHE_TAG = 'id';

    protected function _construct() {
        $this->_init('Raneen\SmsIntegration\Model\ResourceModel\SmsIntegrations');
    }
    public function getIdentities() {
        return [self::CACHE_TAG . '_' . $this->getId() ];
    }
}
