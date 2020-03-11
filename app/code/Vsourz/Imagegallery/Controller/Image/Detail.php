<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vsourz\Imagegallery\Controller\Image;

class Detail extends \Vsourz\Imagegallery\Controller\Index
{
    /**
     * Show Gallery page
     *
     * @return void
     */
    public function execute()
    {
		
        $this->_view->loadLayout();
		
			$catId = $this->getRequest()->getParam('id');
			if($catId){
			   $galleryValue =  $catId;
			   $block = $this->_view->getLayout()->getBlock('image_gallery');
			   $block ->assign(['galleryvalue' => $galleryValue]);
			}else{
				$this->_redirect('');	
			}
		
		$this->_view->renderLayout();
		
    }

}
