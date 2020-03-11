<?php

namespace Vsourz\Imagegallery\Model\ResourceModel;

class ImageGallery extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('vsourz_imagegallery_image_category', 'image_category_id');
    }
}
