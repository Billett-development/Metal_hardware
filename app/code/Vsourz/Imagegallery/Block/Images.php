<?php

namespace Vsourz\Imagegallery\Block;

use Magento\Framework\View\Result\PageFactory;
class Images extends \Magento\Framework\View\Element\Template
{

	protected $resultPageFactory;

    protected $imageFactory;

	protected $categoryFactory;

	protected $imageCategoryFactory;

	protected $_template = 'Vsourz_Imagegallery::imagegallery.phtml';

    protected $_filterProvider;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Vsourz\Imagegallery\Model\ImageFactory $imageFactory,
        \Vsourz\Imagegallery\Model\CategoryFactory $categoryFactory,
        \Vsourz\Imagegallery\Model\ImageGalleryFactory $imageCategoryFactory,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->imageFactory = $imageFactory;
        $this->categoryFactory = $categoryFactory;
        $this->imageCategoryFactory = $imageCategoryFactory;
        $this->_filterProvider = $filterProvider;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$this->resultPageFactory = $resultPageFactory;
    }

	    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        return $this;
    }

    public function objectManager()
    {
        return  $this->_objectManager;
    }

    public function getFilterProvider(){
        return $this->_filterProvider;
    }

    public function getImageCollection(){
              if($this->getCategoryId()) {
			  $selected_category_id   = $this->getCategoryId();
			  $image_id = array();
			  $categoryData = $this->getImageGalleryCollection();
					foreach($categoryData as $_categoryData){
						if($_categoryData['category_id'] == $selected_category_id){
						   $image_id[] = $_categoryData['image_id'];
						}
					}

					$collection   = $this->imageFactory->create()->getCollection();
					$collection->addFieldToFilter('status',1);
					$collection->addFieldToFilter('image_id', array('in' => $image_id));
					$imagedata    = $collection->getData();
		      }else{
                    $imagedata   = "Image Not Exist...!";
              }

			return $imagedata;
     }

    public function getBlockData(){
        return $this->getData('block_params');
    }

    public function getCategoryCollection(){
		    if($this->getCategoryId()){
    			$selected_category_id   = $this->getCategoryId();
    			$collection    = $this->categoryFactory->create()->getCollection();
    			$collection->addFieldToFilter('category_id',$selected_category_id);
                $collection->addFieldToFilter('status',1);
    		    $categorydata  = $collection->getData();
             

		    } else {
		       $categorydata = "";
		    }

            if(!$categorydata) {
                $selected_category_id   = $this->getCategoryId();
                $collection    = $this->categoryFactory->create()->getCollection();
                $collection->addFieldToFilter('category_id',$selected_category_id);
                $categorydata  = $collection->getData();
                $categorydata['catFlag']  = true;
            }

			return $categorydata;
    }
	public function getImageGalleryCollection(){
            $imagegallerycollection    = $this->imageCategoryFactory->create()->getCollection();
		    $imagegallerydata          = $imagegallerycollection->getData();

			return $imagegallerydata;
    }

    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
    }

}
