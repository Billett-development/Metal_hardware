<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml;

abstract class Image extends \Vsourz\Imagegallery\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'image_id';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vsourz_Imagegallery::imagegallery_image');
    }
}
