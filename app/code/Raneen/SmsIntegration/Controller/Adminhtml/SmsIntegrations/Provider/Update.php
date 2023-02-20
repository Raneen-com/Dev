<?php

namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\Provider;

class Update extends \Magento\Backend\App\Action {

    protected $adapterFactory;

    protected $uploader;

    protected $SmsCollection;
    protected $_timezone;

    protected $jsonHelper;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Stdlib\DateTime\DateTime $timezone,
        \Magento\Framework\Json\Helper\Data $jsonHelper,
        \Raneen\SmsIntegration\Model\SmsIntegrationsFactory $smsIntegrationsFactory
    ) {

        parent::__construct($context);

        $this->_timezone = $timezone;
        $this->jsonHelper = $jsonHelper;
        $this->SmsCollection = $smsIntegrationsFactory;

    }

    public function execute(){

        $data = $this->getRequest()->getPostValue();
        try {

            $model = $this->SmsCollection->create();
            foreach ($model->getCollection()->getData() as $dataCollection){
                if($dataCollection["enable"] == "1" && $data['enable'] == "1" && $dataCollection['id'] != $data['id']){
                    $this->messageManager->addError( __('You Cann\'t Add Another Enable Providor') );
                    return $this->_redirect('*/*/index');
                }
            }

            $model->load($data['id']);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This Provider not exists.'));
                return $this->_redirect('*/*/index');
            }

            $model->addData([
                "provider_name" => $data['provider_name'],
                "provider_url" => $data["provider_url"],
                "request_type" => $data["request_type"],
                "request_body" => $data["request_body"],
                "authentication_url" => $data["authentication_url"],
                "authentication_request_type" => $data["authentication_request_type"],
                "authentication_request_body" => $data["authentication_request_body"],
                "authentication_static_header" => $data["authentication_static_header"],
                "enable" => $data['enable'],
                "created_at" => $this->_timezone->gmtDate()
            ]);

            $saveData = $model->save();

            if($saveData){
                $this->messageManager->addSuccess( __('Edit data Successfully !') );
            }

        }catch (\Exception $e) {

            $this->messageManager->addError(__($e->getMessage()));

        }

        $this->_redirect('*/*/index');

    }

}
