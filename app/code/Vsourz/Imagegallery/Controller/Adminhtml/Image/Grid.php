<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

class Grid extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{

    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        return $resultLayout;
    }
}
