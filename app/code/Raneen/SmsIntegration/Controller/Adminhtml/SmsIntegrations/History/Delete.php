<?php
namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\History;
class Delete extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    protected $smsLogsFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,

     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Raneen\SmsIntegration\Model\SmsHistoryFactory $smsLogsFactory){
        parent::__construct($context);
        $this->coreRegistry     = $coreRegistry;
        $this->smsLogsFactory = $smsLogsFactory;

    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page

     */
    public function execute() {
        $rowId = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $smsLogsModel = $this->smsLogsFactory->create();
            $smsLogsModel->load($rowId);
            $smsLogsModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the sms history record.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');

    }
}
