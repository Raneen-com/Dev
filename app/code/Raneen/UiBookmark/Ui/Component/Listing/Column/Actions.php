<?php
namespace Raneen\UiBookmark\Ui\Component\Listing\Column;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Raneen\UiBookmark\Block\Adminhtml\Module\Grid\Renderer\Action\UrlBuilder;
use Magento\Framework\UrlInterface;
use Magento\User\Model\User;

class Actions extends Column {
    /** Url path */
    const URL_PATH_DELETE = 'uibookmark/uibookmarks/delete';
    /** @var UrlBuilder */
    protected $actionUrlBuilder;
    /** @var UrlInterface */
    protected $urlBuilder;

    protected $user;

    protected $authSession;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlBuilder $actionUrlBuilder
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlBuilder $actionUrlBuilder, UrlInterface $urlBuilder, User $user, \Magento\Backend\Model\Auth\Session $authSession,array $components = [], array $data = []) {
        $this->urlBuilder = $urlBuilder;
        $this->actionUrlBuilder = $actionUrlBuilder;
        $this->user = $user;
        $this->authSession = $authSession;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['bookmark_id'])) {
                    $item[$name]['delete'] = ['href' => $this->urlBuilder->getUrl(self::URL_PATH_DELETE, ['bookmark_id' => $item['bookmark_id']]),
                        'label' => __('Delete'),
                        'class' => 'delete',
                        'confirm' => [
                             'title' => __('Confirmation Delete'),
                             'message' => __('Are you sure you wan\'t to delete a record?')
                         ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
