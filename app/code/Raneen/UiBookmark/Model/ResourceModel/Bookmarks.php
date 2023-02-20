<?php
namespace Raneen\UiBookmark\Model\ResourceModel;
class Bookmarks extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('ui_bookmark', 'bookmark_id');
    }
}
