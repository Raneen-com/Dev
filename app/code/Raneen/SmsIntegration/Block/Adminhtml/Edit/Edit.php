<?php

namespace Raneen\SmsIntegration\Block\Adminhtml\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class Edit implements ButtonProviderInterface
{

    public function getButtonData()
    {
        return [
            'label' => __('Edit'),
            'class' => 'edit primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'edit']],
                'form-role' => 'edit',
            ],
            'sort_order' => 90,
        ];
    }

}
