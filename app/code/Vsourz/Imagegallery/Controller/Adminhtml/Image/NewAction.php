<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

class NewAction extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{
    public function execute()
    {
          $resultForward = $this->_resultForwardFactory->create();
          return $resultForward->forward('edit');
		 
    }
}
