<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Category;

use Vsourz\Imagegallery\Model\Enum;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $_categoryCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Vsourz\Imagegallery\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        array $data = []
    ) {
        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }


    protected function _construct()
    {
        parent::_construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('category_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_categoryCollectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
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
            'description',
            [
                'header' => __('Description'),
                'index' => 'description',
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
                'renderer'=>'Vsourz\Imagegallery\Block\Adminhtml\Category\Helper\Renderer\Image'
            ]
        );
		
		/* $this->addColumn(
            'thumbnail_image',
            [
                'header' => __('Thumbnail Image'),
                'index' => 'thumbnail_image',
                'class' => 'xxx',
                'width' => '50px',
				'filter' => false,
                'renderer'=>'Vsourz\Imagegallery\Block\Adminhtml\Category\Helper\Renderer\ThumbnailImage'
            ]
        ); */

        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'class' => 'xxx',
                'width' => '50px',
                'type' => 'options',
                'options' => Enum::getAvailableStatuses(),
            ]
        );
        
        $this->addColumn(
            'edit',
            [
                'header' => __('Edit'),
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => [
                            'base' => '*/*/edit',
                        ],
                        'field' => 'category_id',
                    ],
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action',
            ]
        );
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('category_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => __('Are you sure?'),
            ]
        );
        return $this;
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl(
            '*/*/edit',
            array('category_id' => $row->getId())
        );
    }
}
