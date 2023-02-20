<?php

namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\SendSms;

use Magento\Customer\Model\CustomerFactory;
use Raneen\SmsIntegration\Helper\SendMessages;

class sendSmsListPhones extends \Magento\Backend\App\Action
{
    protected $smsHelper;

    protected $customerFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        SendMessages $smsHelper,
        CustomerFactory $customerFactory
    ) {
        parent::__construct($context);
        $this->smsHelper = $smsHelper;
        $this->customerFactory = $customerFactory;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $arr_phones = explode(",", $data['phones_array']);
        $responseStatus = false;

        try {
            if ($arr_phones) {
                foreach ($arr_phones as $phone) {
                    preg_match_all('/01\d{9}/', $phone, $phoneNumber);

                    if ($phoneNumber[0]) {
                        $response = $this->smsHelper->singleSmsCURL($data["phones_array_messages"], '2' . $phoneNumber[0][0], "Customer Group");
                        if ($response["status"] == 200) {
                            $responseStatus = true;
                        }
                    }
                }
                if ($responseStatus) {
                    $this->messageManager->addSuccess(__('Send SMS Successfully !'));
                }
            }
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }

        return $this->_redirect('*/*/smslistphones');
    }
}
