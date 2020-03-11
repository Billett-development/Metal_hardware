<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image;

use Vsourz\Imagegallery\Model\Enum;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{

    protected $_imageCollectionFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Vsourz\Imagegallery\Model\ResourceModel\Image\CollectionFactory $imageCollectionFactory,
        array $data = []
    ) {
        $this->_imageCollectionFactory = $imageCollectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }


    protected function _construct()
    {
        parent::_construct();
        $this->setId('imageGrid');
        $this->setDefaultSort('image_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }


    protected function _prepareCollection()
    {
        $collection = $this->_imageCollectionFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'image_id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'image_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'image_title',
            [
                'header' => __('Title'),
                'index' => 'image_title',
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
            'image_photo',
            [
                'header' => __('Image'),
                'index' => 'image_photo',
                'class' => 'xxx',
                'width' => '50px',
				'filter' => false,
                'renderer'=>'Vsourz\Imagegallery\Block\Adminhtml\Image\Helper\Renderer\Image'
            ]
        );

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
                        'field' => 'image_id',
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
        $this->setMassactionIdField('image_id');
        $this->getMassactionBlock()->setFormFieldName('image');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('*/*/MassDelete'),
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
            array('image_id' => $row->getId())
        );
    }
}
