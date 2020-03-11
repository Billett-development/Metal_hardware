<?php


namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab;

use Vsourz\Imagegallery\Model\Enum;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
   // const FIELD_NAME_SUFFIX = 'image_data';

    protected $_fieldFactory;

    protected $_wysiwygConfig;

    protected $_imagegalleryHelper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Vsourz\Imagegallery\Helper\Data $imagegalleryHelper,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        array $data = []
    ) {
        $this->_imagegalleryHelper = $imagegalleryHelper;
        $this->_fieldFactory = $fieldFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    protected function _prepareForm()
    {
        $image = $this->getImage();
        $isElementDisabled = true;
        $form = $this->_formFactory->create();

        $dependenceBlock = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Form\Element\Dependence'
        );

        $fieldMaps = [];

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __( 'Image Information')]);

        if ($image->getId()) {
            $fieldset->addField('image_id', 'hidden', ['name' => 'image_id']);
        }

        $fieldset->addField(
            'image_title',
            'text',
            [
                'name' => 'image_title',
                'label' => __('Image Title'),
                'title' => __('Image Title'),
                'required' => true,
                'class' => 'required-entry',
                'maxlength' => 30
            ]
        );
        
        $fieldset->addField(
            'image_title_status',
            'select',
            [
                'label' => __('Display Title'),
                'name' => 'image_title_status',
                'values' => [
                    [
                        'value' => Enum::STATUS_ENABLED,
                        'label' => __('Yes'),
                    ],
                    [
                        'value' => Enum::STATUS_DISABLED,
                        'label' => __('No'),
                    ],
                ],
            ]
        );

        $fieldset->addField(
            'description',
            'text',
            [
                'name' => 'description',
                'label' => __('Image Description'),
                'title' => __('Image Description'),
                'required' => true,
                'class' => 'required-entry',
                'maxlength' => 80
            ]
        );
        
        $fieldset->addField(
            'image_description_status',
            'select',
            [
                'label' => __('Display Description'),
                'name' => 'image_description_status',
                'values' => [
                    [
                        'value' => Enum::STATUS_ENABLED,
                        'label' => __('Yes'),
                    ],
                    [
                        'value' => Enum::STATUS_DISABLED,
                        'label' => __('No'),
                    ],
                ],
            ]
        );

		 $fieldset->addField(
            'image_photo',
            'image',
            [
                'title' => __('Image'),
                'label' => __('Image'),
                'name' => 'image_photo',
                'note' => 'Allow image type: jpg, jpeg, gif, png'
            ]
        );

        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Active Image'),
                'name' => 'status',
                'values' => [
                    [
                        'value' => Enum::STATUS_ENABLED,
                        'label' => __('Yes'),
                    ],
                    [
                        'value' => Enum::STATUS_DISABLED,
                        'label' => __('No'),
                    ],
                ],
            ]
        );
        $form->setValues($image->getData());
	   // $form->addFieldNameSuffix(self::FIELD_NAME_SUFFIX);
        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getImage()
    {
        return $this->_coreRegistry->registry('image');
    }

    public function getPageTitle()
    {
        return $this->getImage()->getId() ? __("Edit Image '%1'", $this->escapeHtml($this->getImage()->getImageTitle())) : __('New Image');
    }

    public function getTabLabel()
    {
        return __( 'Image Information');
    }

    public function getTabTitle()
    {
        return __('Image Information');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

}
