<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Helper\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

	protected $_storeManager;

    protected $_imageFactory;
	
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Vsourz\Imagegallery\Model\ImageFactory $imageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_imageFactory = $imageFactory;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $storeViewId = $this->getRequest()->getParam('store');
        $image = $this->_imageFactory->create()->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $image->getImagePhoto();
        if($image->getImagePhoto() != null){
          return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$image->getImagePhoto().'" />';
        }else{
            return "";
        }
    }
}