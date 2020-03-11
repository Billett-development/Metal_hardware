<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

class Grid extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
{

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        return $resultLayout;
    }
    
}
