<?php

namespace Vsourz\Imagegallery\Model\ResourceModel\Category;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Vsourz\Imagegallery\Model\Category', 'Vsourz\Imagegallery\Model\ResourceModel\Category');
    }

}
