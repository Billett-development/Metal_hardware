<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ibnab\MegaMenu\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Catalog\Model\Category;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface {

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
    public function __construct(CategorySetupFactory $categorySetupFactory) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        $installer = $setup;

        $installer->startSetup();

        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        $megaAttributeGroup = $categorySetup->addAttributeGroup($entityTypeId, $attributeSetId, 'Mega', '1000');

        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'show_products', [
            'type' => 'int',
            'label' => 'Show Products',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 1,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'nbr_product_value', [
            'type' => 'text',
            'label' => 'Numbers Products to Show',
            'input' => 'text',
            'required' => false,
            'sort_order' => 2,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
            'default' => ''
                ]
        );

        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_static_block', [
            'type' => 'int',
            'label' => 'Use Static Block',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 3,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_static_block_top', [
            'type' => 'int',
            'label' => 'Use Static Block Top',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 4,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'static_block_top_value', [
            'type' => 'int',
            'label' => 'Static Block Top Value',
            'input' => 'select',
            'source' => 'Magento\Catalog\Model\Category\Attribute\Source\Page',
            'required' => false,
            'sort_order' => 5,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_static_block_left', [
            'type' => 'int',
            'label' => 'Use Static Block Left',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 6,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'static_block_left_value', [
            'type' => 'int',
            'label' => 'Static Block Left Value',
            'input' => 'select',
            'source' => 'Magento\Catalog\Model\Category\Attribute\Source\Page',
            'required' => false,
            'sort_order' => 7,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_static_block_bottom', [
            'type' => 'int',
            'label' => 'Use Static Block Bottom',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 8,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'static_block_bottom_value', [
            'type' => 'int',
            'label' => 'Static Block Bottom Value',
            'input' => 'select',
            'source' => 'Magento\Catalog\Model\Category\Attribute\Source\Page',
            'required' => false,
            'sort_order' => 9,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_static_block_right', [
            'type' => 'int',
            'label' => 'Use Static Block Right',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 10,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'static_block_right_value', [
            'type' => 'int',
            'label' => 'Static Block Right Value',
            'input' => 'select',
            'source' => 'Magento\Catalog\Model\Category\Attribute\Source\Page',
            'required' => false,
            'sort_order' => 11,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_label', [
            'type' => 'int',
            'label' => 'Use Label',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 12,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'label_value', [
            'type' => 'text',
            'label' => 'Label',
            'input' => 'text',
            'required' => false,
            'sort_order' => 13,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
            'default' => ''
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'level_column_count', [
            'type' => 'varchar',
            'label' => 'Level Column Count',
            'input' => 'select',
            'source' => 'Ibnab\MegaMenu\Model\Category\Attribute\Source\Level',
            'required' => false,
            'sort_order' => 14,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'use_thumbail', [
            'type' => 'int',
            'label' => 'Use Thumbail',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 15,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'disabled_children', [
            'type' => 'int',
            'label' => 'Disabled Category Children',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 16,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $categorySetup->addAttribute(
                \Magento\Catalog\Model\Category::ENTITY, 'category_is_link', [
            'type' => 'int',
            'label' => 'Is Link',
            'input' => 'select',
            'source' => 'Magento\Eav\Model\Entity\Attribute\Source\Boolean',
            'required' => false,
            'sort_order' => 60,
            'global' => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group' => 'Mega',
                ]
        );
        $id = $categorySetup->getAttributeGroupId($entityTypeId, $attributeSetId, 'Mega');
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'show_products', 30
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'nbr_product_value', 31
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_static_block', 32
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_static_block_top', 33
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'static_block_top_value', 34
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_static_block_left', 35
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'static_block_left_value', 36
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_static_block_bottom', 37
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'static_block_bottom_value', 38
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_static_block_right', 39
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'static_block_right_value', 40
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_label', 41
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'label_value', 42
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'use_thumbail', 44
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'disabled_children', 45
        );
        $categorySetup->addAttributeToGroup(
                $entityTypeId, $attributeSetId, $id, 'category_is_link', 46
        );
        $installer->endSetup();
    }

}
