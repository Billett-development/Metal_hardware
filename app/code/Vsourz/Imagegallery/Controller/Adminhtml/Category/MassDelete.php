<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

class MassDelete extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
{

    public function execute()
    {
        $categoryIds = $this->getRequest()->getParam('category');

        if (!is_array($categoryIds) || empty($categoryIds)) {
            $this->messageManager->addError(__('Please select category(s).'));
        } else {
            $categoryCollection = $this->_categoryCollectionFactory->create()->addFieldToFilter('category_id', ['in' => $categoryIds]);
            
            try {
                foreach ($categoryCollection as $category) {
                    $category->delete();
                }

                $imageCategoryCollection = $this->_objectManager->create('\Vsourz\Imagegallery\Model\ResourceModel\ImageGallery\CollectionFactory')->create()->addFieldToFilter('category_id', ['in' => $categoryIds]);
                
                foreach ($imageCategoryCollection as $imagecategory) {
                    $imagecategory->delete();
                }

                $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($categoryIds)));
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
