<?php

namespace Meetanshi\Callforprice\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Typeas implements ArrayInterface
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'button', 'label' => __('Button')],
            ['value' => 'label', 'label' => __('Label')]
        ];
    }
}
