<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

use Magento\Backend\App\Action;

class Categorys extends \Magento\Backend\App\Action
{

    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory
    ) {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    protected function _isAllowed()
    {
        return true;
    }

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('image.edit.tab.categorys')
                     ->setInProducts($this->getRequest()->getPost('image_products', null));

        return $resultLayout;
    }
}
