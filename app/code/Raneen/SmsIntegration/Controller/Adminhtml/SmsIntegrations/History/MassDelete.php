<?php
namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\History;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Model\Bookmark;
class MassDelete extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    protected $smsLogsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,

     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Raneen\SmsIntegration\Model\SmsHistoryFactory $smsLogsFactory)      {
        parent::__construct($context);
        $this->coreRegistry     = $coreRegistry;
        $this->smsLogsFactory = $smsLogsFactory;
    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page

     */
    public function execute()      {
        $resultRedirect = $this->resultRedirectFactory->create();

        foreach ($this->getRequest()->getParams()['selected'] as $logID){
            $rowId = $logID;
            $resultRedirect = $this->resultRedirectFactory->create();
            try {
                $smsLogsModel = $this->smsLogsFactory->create();
                $smsLogsModel->load($rowId);
                $smsLogsModel->delete();
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }
        $this->messageManager->addSuccessMessage(__('You deleted the sms history records.'));

        return $resultRedirect->setPath('*/*/');

    }
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Raneen_UiBookamrk::delete');

    }
}
