<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Raneen\UiBookmark\Model\Config\Source;

use Magento\Authorization\Model\ResourceModel\Role\CollectionFactory;

/**
 * @api
 * @since 100.0.2
 */
class ListAdminRole implements \Magento\Framework\Option\ArrayInterface
{

    protected $collectionFactory;
    protected $options = null;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {

        $roles = $this->collectionFactory->create();
        foreach ($roles->getData() as $role) {
            if($role['user_id'] == 0){
                $this->options[] = [
                    'value' => $role['role_id'],
                    'label' => $role['role_name'],
                ];
            }
        }


        return $this->options;
    }

}
