<?php
namespace Raneen\UiBookmark\Controller\Adminhtml\UiBookmarks;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Model\Bookmark;
class Delete extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    private $bookmarksFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,

     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry,\Raneen\UiBookmark\Model\BookmarksFactory $bookmarksFactory)      {
        parent::__construct($context);
        $this->coreRegistry     = $coreRegistry;
        $this->bookmarksFactory = $bookmarksFactory;
    }


    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page

     */
    public function execute()      {
        $rowId = (int)$this->getRequest()->getParam('bookmark_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $uiBookmarkModel = $this->bookmarksFactory->create();
            $uiBookmarkModel->load($rowId);
            $uiBookmarkModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the bookmark record.!!!!!!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');

    }
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Raneen_UiBookamrk::delete');

    }
}
