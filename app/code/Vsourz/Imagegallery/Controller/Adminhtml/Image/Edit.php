<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

class Edit extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $id = $this->getRequest()->getParam('image_id');
        $model = $this->_imageFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This image no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('image', $model);

        return $resultPage;
    }
}
