<?php
namespace Raneen\SmsIntegration\Model\ResourceModel;
class SmsIntegrations extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('sms_providers', 'id');
    }
}
