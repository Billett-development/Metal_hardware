<?php

namespace Vsourz\Imagegallery\Model\ResourceModel\ImageGallery;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Vsourz\Imagegallery\Model\ImageGallery', 'Vsourz\Imagegallery\Model\ResourceModel\ImageGallery');
    }
}
