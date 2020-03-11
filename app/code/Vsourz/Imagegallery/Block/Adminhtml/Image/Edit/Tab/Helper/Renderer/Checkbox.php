<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer;

class Checkbox extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\Checkbox
{

    public function render(\Magento\Framework\DataObject $row)
    {
        $id = $row->getId();
        $values = $this->getColumn()->getValues();
        $html = '<label class="data-grid-checkbox-cell-inner" for="id_'.$id.'"><input name="selectedCategorys['.$id.']" value="'.$id.'" id="id_'.$id.'" class="checkbox admin__control-checkbox" type="checkbox" ';
        if (is_array($values)) {
            $html .= in_array($id, $values) ? ' checked="checked"' : '';
        }
        $html .=' ><label for="id_'.$id.'"></label></label>';
        return $html;
    }
}