<?php

namespace Vsourz\Imagegallery\Block\Adminhtml;

class Image extends \Magento\Backend\Block\Widget\Grid\Container
{

    protected function _construct()
    {
        $this->_controller = 'adminhtml_image';
        $this->_blockGroup = 'Vsourz_Imagegallery';
        $this->_headerText = __('Images');
        $this->_addButtonLabel = __('Add New Image');
        parent::_construct();
    }
}
