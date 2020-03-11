<?php


namespace Vsourz\Imagegallery\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Cms\Model\Page;
use Magento\Cms\Model\PageFactory;

class InstallSchema implements InstallSchemaInterface
{
	
	/**
     * Page factory.
     *
     * @var PageFactory
     */
    private $pageFactory;
	
	/**
     * Init.
     *
     * @param PageFactory $pageFactory
     */
	 
	public function __construct(PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
    }

    /**
     * Upgrade.
     *
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */



    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        $optionsPage = $this->pageFactory->create()->getCollection()->getData();

        $pageIdentifierList = [];
        $pageExist;

        foreach ($optionsPage as $optinIdfier) {
            $pageIdentifierList[] = $optinIdfier['identifier'];
        }

        if (in_array('gallery.html', $pageIdentifierList)) {
            $pageExist = true;
        } else {
            $pageExist = false;
        }

        
		// Create cms page for image gallery
		if (version_compare($context->getVersion(), '0.0.1') < 0 && $pageExist === false) {
            $cmsPage = [
                'title' => 'Gallery',
                'identifier' => 'gallery.html',
                'stores' => [0],
                'is_active' => 1,
                'content_heading' => '',
                'content' => '<p>{{block class="Vsourz\Imagegallery\Block\Images" category_id="1" template="Vsourz_Imagegallery::imagegallery.phtml"}}</p>',
                'page_layout' => '1column'
            ];

            $this->pageFactory->create()->setData($cmsPage)->save();
        }
		

        $installer->getConnection()->dropTable($installer->getTable('vsourz_imagegallery_image'));
        $installer->getConnection()->dropTable($installer->getTable('vsourz_imagegallery_category'));
        $installer->getConnection()->dropTable($installer->getTable('vsourz_imagegallery_image_category'));

        /* Start : vsourz_imagegallery_image */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('vsourz_imagegallery_image')
        )->addColumn(
            'image_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Image ID'
        )->addColumn(
            'image_title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => '1'],
            'Image Title'
        )->addColumn(
            'image_title_status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => '1'],
            'Image Title Status'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Image Description'
        )->addColumn(
            'image_description_status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => '1'],
            'Image Description Status'
        )->addColumn(
            'image_photo',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Gallery Image'
        )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => true, 'default' => '1'],
            'Image Status'
        )->addIndex(
            $installer->getIdxName('vsourz_imagegallery_image', ['image_id']),
            ['image_id']
        )->setComment(
            'Vsourz Imagegallery Image Table'
        );

        $installer->getConnection()->createTable($table);

        /* End : vsourz_imagegallery_image */

        /* Start : vsourz_imagegallery_category */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('vsourz_imagegallery_category')
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Category ID'
        )->addColumn(
            'title',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => ''],
            'Category Title'
        )->addColumn(
            'title_status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => '1'],
            'Title Status'
        )->addColumn(
            'description',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => true],
            'Category Description'
        )->addColumn(
            'description_status',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => false, 'default' => '1'],
            'Description Status'
        )->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            255,
            ['nullable' => true],
            'Category Image'
	    )->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['nullable' => false, 'default' => '1'],
            'Category Status'
        )->addIndex(
            $installer->getIdxName('vsourz_imagegallery_category', ['category_id']),
            ['category_id']
        )->setComment(
            'Vsourz Imagegallery Category Table'
        );

        $installer->getConnection()->createTable($table);

        /* End : vsourz_imagegallery_category */

        /* Start : vsourz_imagegallery_category */

        $table = $installer->getConnection()->newTable(
            $installer->getTable('vsourz_imagegallery_image_category')
        )->addColumn(
            'image_category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
            'Image Category ID'
        )->addColumn(
            'image_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => false],
            'Image ID'
        )->addColumn(
            'category_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => false],
            'Category ID'
        )->addColumn(
            'position',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['nullable' => false, 'default' => '1'],
            'Category Position'
        )->addIndex(
            $installer->getIdxName('vsourz_imagegallery_image_category', ['image_category_id']),
            ['image_category_id']
        )->setComment(
            'Vsourz Imagegallery Image Category Table'
        );

        $installer->getConnection()->createTable($table);

        /* End : vsourz_imagegallery_category */

        $installer->endSetup();
    }
}
