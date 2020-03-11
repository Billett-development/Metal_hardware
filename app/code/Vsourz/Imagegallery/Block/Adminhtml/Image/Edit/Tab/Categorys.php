<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab;

use Vsourz\Imagegallery\Model\ImageFactory;

class Categorys extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $categoryCollectionFactory;

    protected $imageFactory;

    protected $imageCategoryFactory;

    protected $registry;

    protected $_objectManager = null;

    public $existingCategorys = array();

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Vsourz\Imagegallery\Model\ImageFactory $imageFactory,
        \Vsourz\Imagegallery\Model\ImageGalleryFactory $imageCategoryFactory,
        \Vsourz\Imagegallery\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->imageFactory = $imageFactory;
        $this->imageCategoryFactory = $imageCategoryFactory;
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('categorysGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $imageId = $this->getRequest()->getParam('image_id');
        $this->existingCategorys = $this->getImageGalleryArray();
        $collection = $this->categoryCollectionFactory->create()->load();
		if($imageId != null){
        $collection->getSelect()->joinLeft(array('image_category' => 'vsourz_imagegallery_image_category'),'image_category.image_id = '.$imageId.' AND main_table.category_id = image_category.category_id ',array('image_category.position'))->order('image_category.position','asc'); 
		}
		
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    public function getImageGalleryArray()
    {
        $list =array();
        $imageId = $this->getRequest()->getParam('image_id');
		 if($imageId != null){
        $data   = $this->imageCategoryFactory->create()->load(null)->getCollection()->addFieldToFilter('main_table.image_id',$imageId)->getData();
        if($data){
            foreach ($data as $key => $value) {
               $list[] = $value['category_id'];
            }
         }
	    }
        return $list;
    }


    protected function _prepareColumns()
    {

        $this->addColumn(
            'selectedCategorys',
            [
			    'header' => __(''),
                'header_css_class' => 'a-center',
                'name' => 'selectedCategorys',
                'align' => 'center',
                'index' => 'category_id',
				'filter' => false,
				'sortable' => false,
                'renderer' => 'Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer\Checkbox',
                'values' => $this->getImageGalleryArray()
            ]
        );

        $this->addColumn(
            'category_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'category_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'title',
            [
                'header' => __('Title'),
                'index' => 'title',
                'class' => 'xxx',
                'width' => '50px',
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('Category Image'),
                'index' => 'image',
                'class' => 'xxx',
                'width' => '50px',
				'filter' => false,
                'renderer' => 'Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer\Image'
            ]
        );


       /* $this->addColumn(
            'position',
            [
                'header' => __('Category Position'),
                'name' => 'position',
                'index' => 'category_id',
                'class' => 'xxx',
                'width' => '50px',
                'renderer' => 'Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer\Position'
            ]
        );
		*/
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/categorys', ['_current' => true]);
    }

    public function getRowUrl($row)
    {
        return '';
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return true;
    }
}
