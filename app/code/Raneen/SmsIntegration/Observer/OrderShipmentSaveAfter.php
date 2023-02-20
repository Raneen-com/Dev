<?php

namespace Raneen\SmsIntegration\Observer;

use Magento\Framework\Event\ObserverInterface;
use Psr\Log\LoggerInterface;
use Raneen\SmsIntegration\Helper\SendMessages;

class OrderShipmentSaveAfter implements ObserverInterface
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
        $shipment = $observer->getEvent()->getShipment();
        dd($shipment);
        $tracksCollection = $shipment->getTracksCollection();
        //dd($tracksCollection->getItems());
        foreach ($tracksCollection->getItems() as $track) {
            //dd($track);
            $track_number = $track->getTrackNumber();
            $carrier_name = $track->getTitle();
        }

    }
}
