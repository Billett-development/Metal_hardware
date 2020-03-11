<?php
/**
 * @author      WebPanda
 * @package     WebPanda_AutoInvoice
 * @copyright   Copyright (c) WebPanda (https://webpanda-solutions.com/)
 * @license     https://webpanda-solutions.com/license-agreement
 */

namespace WebPanda\AutoInvoice\Model\Config\Source;

/**
 * Class OrderTotal
 * @package WebPanda\AutoInvoice\Model\Config\Source
 */
class OrderTotal implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'zero_total', 'label' => __('With 0 Grand Total')],
            ['value' => 'all', 'label' => __('All Orders')]
        ];
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return ['zero_total' => __('With 0 Grand Total'), 'all' => __('All Orders')];
    }
}
