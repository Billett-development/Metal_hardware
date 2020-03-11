<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

class Index extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{
    public function execute()
    {
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->_resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
