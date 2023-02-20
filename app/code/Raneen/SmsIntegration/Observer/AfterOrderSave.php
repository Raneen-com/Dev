<?php

namespace Raneen\SmsIntegration\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Raneen\SmsIntegration\Helper\SendMessages;

class AfterOrderSave implements ObserverInterface
{
    protected $logger;
    protected $smsHelper;

    public function __construct(
        LoggerInterface$logger,
        SendMessages $smsHelper
    ) {
        $this->logger = $logger;
        $this->smsHelper = $smsHelper;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();

//        if ($order->getBillingAddress()->getTelephone()) {
//            $this->logger->critical('Order Status ' . $order->getState());
//            $this->logger->critical('telephone ' . $order->getBillingAddress()->getTelephone());
//            $this->smsHelper->singleSmsCURL('Your order (' . $order->getIncrementId() . ') Status: ' . $order->getState(), $order->getBillingAddress()->getTelephone(), "Change Order Status");
//        }
    }
}
