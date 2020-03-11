<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit;

class Tabs extends \Magento\Backend\Block\Widget\Tabs
{
    protected function _construct()
    {
        parent::_construct();
        $this->setId('image_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Image Information'));
    }
}
