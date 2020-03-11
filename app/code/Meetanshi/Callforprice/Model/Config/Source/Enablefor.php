<?php

namespace Meetanshi\Callforprice\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Enablefor implements ArrayInterface
{
    
    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'global', 'label' => __('Global')],
            ['value' => 'category', 'label' => __('Category specific')],
            ['value' => 'product', 'label' => __('Product specific')]
        ];
    }
}
