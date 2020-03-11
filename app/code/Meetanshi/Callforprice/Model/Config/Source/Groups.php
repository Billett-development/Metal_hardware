<?php

namespace Meetanshi\Callforprice\Model\Config\Source;

use Magento\Customer\Model\ResourceModel\Group\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;

class Groups implements ArrayInterface
{
    private $options;
    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        if (!$this->options) {
            $this->options = $this->collectionFactory->create()->setRealGroupsFilter()->loadData()->toOptionArray();
            array_unshift($this->options, ['value' => '0', 'label' => __('NOT LOGGED IN')]);
        }

        return $this->options;
    }
}
