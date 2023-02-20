<?php

namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\Provider;
class Edit extends \Magento\Backend\App\Action
{

    protected $resultPageFactory;

    public function __construct(

        \Magento\Backend\App\Action\Context        $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
    )
    {

        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;

    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Edit SMS Provider'));
        return $resultPage;
    }
}
