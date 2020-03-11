<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ibnab\MegaMenu\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Catalog\Setup\CategorySetupFactory;

/**
 * Upgrade Data script
 *
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class UpgradeData implements UpgradeDataInterface {

    /**
     * Category setup factory
     *
     * @var CategorySetupFactory
     */
    private $categorySetupFactory;

    /**
     * Constructor
     *
     * @param CategorySetupFactory $categorySetupFactory
     */
    public function __construct(
    CategorySetupFactory $categorySetupFactory
    ) {
        $this->categorySetupFactory = $categorySetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context) {
        
        $setup->startSetup();
        $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);
        $entityTypeId = $categorySetup->getEntityTypeId(\Magento\Catalog\Model\Category::ENTITY);
        $attributeSetId = $categorySetup->getDefaultAttributeSetId($entityTypeId);
        if (version_compare($context->getVersion(), '1.1.0') < 0) {
            $attribute = $categorySetup->getAttribute($entityTypeId,'category_is_link');
            if(!isset($attribute['attribute_id'])){
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
                    $entityTypeId, $attributeSetId, $id, 'category_is_link', 6
            );
            }
        }

        $setup->endSetup();
    }

}
