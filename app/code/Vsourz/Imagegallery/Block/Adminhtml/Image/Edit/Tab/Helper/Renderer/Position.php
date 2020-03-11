<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer;

class Position extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Input
{
	
    public function render(\Magento\Framework\DataObject $row)
    {
        $html = '<input type="text"';
        $html .= 'name="' . $this->getColumn()->getId() . '['. $row->getData('category_id') . ']" ';
        $html .= 'value="' . $row->getData('position') . '"';
        return $html . ' />';
    }
}