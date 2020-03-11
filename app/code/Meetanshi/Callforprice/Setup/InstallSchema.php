<?php

namespace Meetanshi\Callforprice\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Get Callforprice table
        $tableName = $installer->getTable('meetanshi_callforprice');
        // Check if the table already exists
        if ($installer->getConnection()->isTableExists($tableName) != true) {
            // Create tutorial_simplenews table
            $table = $installer->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                    'ID'
                )
                ->addColumn(
                    'cname',
                    Table::TYPE_TEXT,
                    100,
                    ['nullable' => false, 'default' => ''],
                    'Customer Name'
                )
                ->addColumn(
                    'email',
                    Table::TYPE_TEXT,
                    125,
                    ['nullable' => false, 'default' => ''],
                    'Email'
                )
                ->addColumn(
                    'country',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Country'
                )
                ->addColumn(
                    'phone_number',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'PHONE NUMBER'
                )
                ->addColumn(
                    'comment',
                    Table::TYPE_TEXT,
                    null,
                    ['nullable' => false, 'default' => ''],
                    'Comment'
                )
                ->addColumn(
                    'productid',
                    Table::TYPE_INTEGER,
                    null,
                    [true, 'nullable' => false],
                    'ID'
                )
                ->setComment('Meetanshi_Callforprice');

            $installer->getConnection()->createTable($table);

            $installer->getConnection()->addIndex(
                $installer->getTable('meetanshi_callforprice'),
                $setup->getIdxName(
                    $installer->getTable('meetanshi_callforprice'),
                    ['cname','email','comment','phone_number'],
                    AdapterInterface::INDEX_TYPE_FULLTEXT
                ),
                ['cname','email','comment','phone_number'],
                AdapterInterface::INDEX_TYPE_FULLTEXT
            );
        }
        $installer->endSetup();
    }
}
