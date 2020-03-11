<?php

namespace Vsourz\Imagegallery\Block\Adminhtml\Image\Edit\Tab\Helper\Renderer;

class Image extends \Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer
{

	protected $_storeManager;

    protected $_categoryFactory;
	
    public function __construct(
        \Magento\Backend\Block\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Vsourz\Imagegallery\Model\CategoryFactory $categoryFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_storeManager = $storeManager;
        $this->_categoryFactory = $categoryFactory;
    }

    public function render(\Magento\Framework\DataObject $row)
    {
        $category = $this->_categoryFactory->create()->load($row->getId());
        $srcImage = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $category->getImage();
        if($category->getImage() != null){
          return '<image width="150" height="50" src ="'.$srcImage.'" alt="'.$category->getImage().'" />';
        }else{
            return "";
        }
    }
}