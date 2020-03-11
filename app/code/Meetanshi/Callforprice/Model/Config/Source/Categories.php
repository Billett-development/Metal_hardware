<?php

namespace Meetanshi\Callforprice\Model\Config\Source;

use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\Option\ArrayInterface;
use Magento\Store\Model\StoreManagerInterface;

class Categories implements ArrayInterface
{
    protected $categoryCollection;
    protected $storeManager;

    public function __construct(CollectionFactory $categoryCollection, StoreManagerInterface $storeManager
    )
    {
        $this->categoryCollection = $categoryCollection;
        $this->storeManager = $storeManager;
    }

    public function toOptionArray()
    {
        $categories = $this->categoryCollection->create()->addAttributeToSelect('*')->setStore($this->storeManager->getStore());
        $options = [];
        foreach ($categories as $category) {
            if ($category->getName() != 'Root Catalog') {
                $options[] = [
                    'value' => $category->getId(),
                    'label' => $category->getName()

                ];
            }
        }
        return $options;
    }
}
