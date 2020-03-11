<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml;

abstract class Category extends \Vsourz\Imagegallery\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'category_id';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Vsourz_Imagegallery::imagegallery_category');
    }
}
