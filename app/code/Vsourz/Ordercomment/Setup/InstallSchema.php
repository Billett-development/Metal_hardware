<?php

namespace Vsourz\Ordercomment\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'order_comments',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order Comments',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('quote'),
            'order_for',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order File Attachment',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'order_comments',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order Comments',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order'),
            'order_for',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order File Attachment',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'order_comments',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order Comments',
            ]
        );

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'order_for',
            [
                'type' => 'text',
                'nullable' => true,
                'comment' => 'Order File Attachment',
            ]
        );

        $setup->endSetup();
    }
}
