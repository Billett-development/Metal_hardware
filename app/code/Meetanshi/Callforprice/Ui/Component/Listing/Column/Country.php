<?php

namespace Meetanshi\Callforprice\Ui\Component\Listing\Column;

use Magento\Framework\Option\ArrayInterface;
use Magento\Directory\Model\ResourceModel\Country\CollectionFactory;

class Country implements ArrayInterface
{
    private $countryCollectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    )
    {
        $this->countryCollectionFactory = $collectionFactory;
    }

    public function toOptionArray()
    {
        $countryCollection = $this->countryCollectionFactory->create();
        return $countryCollection->toOptionArray();
    }
}