<?php

namespace Raneen\SmsIntegration\Ui\Component\Listing\History;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\User\Model\User;
use Raneen\SmsIntegration\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Raneen\SmsIntegration\Model\SmsIntegrations;

class Actions extends Column
{
    /** Url path */
    const URL_PATH_DELETE = 'smsintegration/SmsIntegrations_History/delete';

    /** @var UrlBuilder */
    protected $actionUrlBuilder;
    /** @var UrlInterface */
    protected $urlBuilder;

    protected $provider;

    protected $authSession;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlBuilder $actionUrlBuilder, UrlInterface $urlBuilder, SmsIntegrations $provider, \Magento\Backend\Model\Auth\Session $authSession, array $components = [], array $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->provider = $provider;
        $this->authSession = $authSession;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                $item[$name]['delete'] = ['href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['id' => $item['id']]),
                    'label' => __('Delete'),
                    'class' => 'delete',
                    'confirm' => [
                        'title' => __('Confirmation Delete'),
                        'message' => __('Are you sure you want to delete a sms history record?')
                    ]
                ];
            }
        }
        return $dataSource;
    }

}
