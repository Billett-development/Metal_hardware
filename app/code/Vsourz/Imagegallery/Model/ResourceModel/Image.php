<?php

namespace Vsourz\Imagegallery\Model\ResourceModel;

class Image extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('vsourz_imagegallery_image', 'image_id');
    }
}
