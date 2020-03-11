<?php

namespace Vsourz\Imagegallery\Block\Adminhtml;

class Category extends \Magento\Backend\Block\Widget\Grid\Container
{

    protected function _construct()
    {
        $this->_controller = 'adminhtml_category';
        $this->_blockGroup = 'Vsourz_Imagegallery';
        $this->_headerText = __('Categories');
        $this->_addButtonLabel = __('Add New Category');
        parent::_construct();
    }
}
