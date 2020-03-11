<?php

namespace Meetanshi\Callforprice\Model\ResourceModel\Callforprice;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'Meetanshi\Callforprice\Model\Callforprice',
            'Meetanshi\Callforprice\Model\ResourceModel\Callforprice'
        );
    }
}
