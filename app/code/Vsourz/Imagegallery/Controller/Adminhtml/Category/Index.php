<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

class Index extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
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
