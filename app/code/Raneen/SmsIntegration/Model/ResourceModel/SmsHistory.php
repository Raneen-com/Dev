<?php
namespace Raneen\SmsIntegration\Model\ResourceModel;
class SmsHistory extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('sms_history', 'id');
    }
}
