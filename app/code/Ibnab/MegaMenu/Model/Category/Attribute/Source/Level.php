<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ibnab\MegaMenu\Model\Category\Attribute\Source;

/**
 * Catalog product landing page attribute source
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Level extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{

    /**
     * @return array
     */
    public function getAllOptions()
    {

        $option[] = ['value' => 'column_mega_menu1', 'label' => __('1 column')];
        $option[] = ['value' => 'column_mega_menu2', 'label' => __('2 column')];
        $option[] = ['value' => 'column_mega_menu3', 'label' => __('3 column')];
        $option[] = ['value' => 'column_mega_menu4', 'label' => __('4 column')];

        return $option;
    }
}
