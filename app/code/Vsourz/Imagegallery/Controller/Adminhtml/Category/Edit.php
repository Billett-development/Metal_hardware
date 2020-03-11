<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

class Edit extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
{

    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        $id = $this->getRequest()->getParam('category_id');
        $model = $this->_categoryFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This category no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('category', $model);

        return $resultPage;
    }
}
