<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Category;

class Edit extends \Magento\Backend\Block\Widget\Form\Container
{

    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }
    protected function _construct()
    {
        $this->_objectId = 'category_id';
        $this->_blockGroup = 'Vsourz_Imagegallery';
        $this->_controller = 'adminhtml_category';

        parent::_construct();

        $this->buttonList->update('save', 'label', __('Save Category'));
		$this->buttonList->remove('delete');

        if ($this->getRequest()->getParam('category_id')) {
            $this->addButton(
                'delete',
                [
                    'label'   => __('Delete Category'),
                    'class'   => 'delete',
                    'onclick' => 'deleteConfirm(\'' . __(
                            'Are you sure you want to do this?'
                        ) . '\', \'' . $this->getDeleteUrl() . '\')',
                ]
            );

            $this->buttonList->add(
                'save_and_continue',
                [
                    'label'          => __('Save and Continue Edit'),
                    'class'          => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ],
                ],
                10
            );

            $this->_formScripts[] = "
				require(['jquery'], function($){
					$(document).ready(function(){
						var input = $('<input class=\"custom-button-submit\" type=\"submit\" hidden=\"true\" />');
						$(edit_form).append(input);
						window.customsaveAndContinueEdit = function (){
							edit_form.action = '" . $this->getSaveAndContinueUrl() . "';
							$('.custom-button-submit').trigger('click');
				        }
					});
				});
			";
        } else {

            $this->buttonList->add(
                'save_and_continue',
                [
                    'label'          => __('Save and Continue Edit'),
                    'class'          => 'save',
                    'data_attribute' => [
                        'mage-init' => [
                            'button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form'],
                        ],
                    ],
                ],
                10
            );
        }
    }

    public function getImage()
    {
        return $this->_coreRegistry->registry('category');
    }

}
