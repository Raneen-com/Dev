<?php
namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\Provider;
class Delete extends \Magento\Backend\App\Action {

    /**
     * @var \Magento\Framework\Registry
     */
    private $coreRegistry;

    protected $smsProviderFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry,

     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry, \Raneen\SmsIntegration\Model\SmsIntegrationsFactory $smsIntegrationsFactor){
        parent::__construct($context);
        $this->coreRegistry     = $coreRegistry;
        $this->smsProviderFactory = $smsIntegrationsFactor;

    }

    /**
     * Mapped Grid List page.
     * @return \Magento\Backend\Model\View\Result\Page

     */
    public function execute() {
        $rowId = (int)$this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        try {
            $smsProviderModel = $this->smsProviderFactory->create();
            $smsProviderModel->load($rowId);
            $smsProviderModel->delete();
            $this->messageManager->addSuccessMessage(__('You deleted the sms provider record.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('*/*/');

    }
    protected function _isAllowed() {
        return $this->_authorization->isAllowed('Raneen_UiBookamrk::delete');

    }
}
