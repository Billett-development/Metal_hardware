<?php

namespace Vsourz\Imagegallery\Model\ResourceModel;

class Category extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('vsourz_imagegallery_category', 'category_id');
    }
}
