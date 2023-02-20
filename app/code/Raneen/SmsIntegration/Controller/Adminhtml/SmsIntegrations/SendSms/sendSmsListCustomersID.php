<?php

namespace Raneen\SmsIntegration\Controller\Adminhtml\SmsIntegrations\SendSms;

use Magento\Customer\Model\CustomerFactory;
use Raneen\SmsIntegration\Helper\SendMessages;

class sendSmsListCustomersID extends \Magento\Backend\App\Action
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
        $arr_customer_ids = explode(",", $data['customer_ids']);
        $responseStatus = false;
        $customers = [];

        foreach ($arr_customer_ids as $id) {
            $customerModel = $this->customerFactory->create()->getCollection();
            $customerModel->getSelect()->join(['cae' => 'customer_address_entity'], 'e.entity_id = cae.parent_id', "telephone");
            $customerModel->addFieldToFilter('entity_id', ['eq' => $id]);
            if (isset($customerModel->getData()[0])) {
                $customers[] = $customerModel->getData()[0];
            }
        }

        if ($customers) {
            try {
                foreach ($customers as $customer) {
                    preg_match_all('/01\d{9}/', $customer['telephone'], $phoneNumber);

                    if ($phoneNumber[0]) {
                        $response = $this->smsHelper->singleSmsCURL($data["message"], '2' . $phoneNumber[0][0], "Customer IDs");
                        if ($response["status"] == 200) {
                            $responseStatus = true;
                        }
                    }
                }
                if ($responseStatus) {
                    $this->messageManager->addSuccess(__('Send SMS Successfully !'));
                }
            } catch (\Exception $e) {
                $this->messageManager->addError(__($e->getMessage()));
            }
        } else {
            $this->messageManager->addError(__("There are no customers"));
        }

        return $this->_redirect('*/*/smslistcustomers');
    }
}
