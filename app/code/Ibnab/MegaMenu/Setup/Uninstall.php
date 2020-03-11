<?php
/**
 * @author Atwix Team
 * @copyright Copyright (c) 2016 Atwix (https://www.atwix.com/)
 * @package Atwix_SampleSetup
 */

namespace Ibnab\MegaMenu\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UninstallInterface as UninstallInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
/**
 * Class Uninstall
 */
class Uninstall implements UninstallInterface
{
    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * Init
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(CategorySetupFactory $categorySetupFactory)
    {
        $this->categorySetupFactory = $categorySetupFactory;
    }
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $allAttributes = ['show_products','nbr_product_value','use_static_block','use_static_block_top','static_block_top_value','use_static_block_left',
            'static_block_left_value','use_static_block_bottom','static_block_bottom_value','use_static_block_right','static_block_right_value','use_label','label_value',
            'level_column_count','use_thumbail','disabled_children'];
        foreach($allAttributes as $attribute){
            $categorySetup->removeAttribute($entityTypeId,$attribute);
        }
        $installer->endSetup();
    }
}