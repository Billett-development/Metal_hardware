<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

class NewAction extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
{
    public function execute()
    {
        $resultForward = $this->_resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
