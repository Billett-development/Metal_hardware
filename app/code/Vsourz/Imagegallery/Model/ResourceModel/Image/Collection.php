<?php

namespace Vsourz\Imagegallery\Model\ResourceModel\Image;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Vsourz\Imagegallery\Model\Image', 'Vsourz\Imagegallery\Model\ResourceModel\Image');
    }
}
