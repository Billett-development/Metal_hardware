<?php


namespace Vsourz\Imagegallery\Block\Adminhtml\Category\Edit\Tab;

use Vsourz\Imagegallery\Model\Enum;

class Form extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    const FIELD_NAME_SUFFIX = 'category';

    protected $_fieldFactory;

    protected $_wysiwygConfig;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Config\Model\Config\Structure\Element\Dependency\FieldFactory $fieldFactory,
        array $data = []
    ) {
        $this->_fieldFactory = $fieldFactory;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareLayout()
    {
        $this->getLayout()->getBlock('page.title')->setPageTitle($this->getPageTitle());
    }

    protected function _prepareForm()
    {
        $category = $this->getCategory();
        $isElementDisabled = true;
        $form = $this->_formFactory->create();

        $dependenceBlock = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Form\Element\Dependence'
        );

        $fieldMaps = [];

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __( 'Category Information')]);

        if ($category->getId()) {
            $fieldset->addField('category_id', 'hidden', ['name' => 'category_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Title'),
                'title' => __('Title'),
                'required' => true,
				'maxlength' => 30
            ]
        );
        
        $fieldset->addField(
            'title_status',
            'select',
            [
                'label' => __('Display Title'),
                'name' => 'title_status',
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

        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $this->_wysiwygConfig = $this->_objectManager->create('\Magento\Cms\Model\Wysiwyg\Config');
        
        $fieldset->addField(
            'description',
            'editor',
            [
                'name' => 'description',
                'label' => __('Description'),
                'title' => __('Description'),
                'required' => false,
                'wysiwyg' => true,
                'config' => $this->_wysiwygConfig->getConfig()
            ]
        );
        
        $fieldset->addField(
            'description_status',
            'select',
            [
                'label' => __('Display Description'),
                'name' => 'description_status',
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
            'image',
            'image',
            [
                'title' => __('Category Image'),
                'label' => __('Category Image'),
                'name' => 'image',
                'note' => 'Allow image type: jpg, jpeg, gif, png'
            ]
        );
        
        $fieldset->addField(
            'status',
            'select',
            [
                'label' => __('Category Enable'),
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
		
        $form->setValues($category->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }


    public function getCategory()
    {
        return $this->_coreRegistry->registry('category');
    }

    public function getPageTitle()
    {
        return __('New Category');
    }

    /**
     * Prepare label for tab.
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __( 'Category Information');
    }

    /**
     * Prepare title for tab.
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Category Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
