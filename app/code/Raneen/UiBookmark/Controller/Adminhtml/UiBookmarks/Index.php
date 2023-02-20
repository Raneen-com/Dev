<?php
namespace Raneen\UiBookmark\Controller\Adminhtml\UiBookmarks;
class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory = false;
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\View\Result\PageFactory $resultPageFactory)
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('UibookmarkId');
        $resultPage->getConfig()->getTitle()->prepend((__('Ui Bookmark')));
        return $resultPage;
    }
//
//    protected function _isAllowed()
//    {
//        return $this->_authorization->isAllowed('Magento_Customer::manage');
//    }

}
