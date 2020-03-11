<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

class MassDelete extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{

    public function execute()
    {
        $imageIds = $this->getRequest()->getParam('image');

        if (!is_array($imageIds) || empty($imageIds)) {
            $this->messageManager->addError(__('Please select image(s).'));
        } else {
            $imageCollection = $this->_imageCollectionFactory->create()->addFieldToFilter('image_id', ['in' => $imageIds]);
            try {
                foreach ($imageCollection as $image) {
                    $image->delete();
                }


                $imageCategoryCollection = $this->_objectManager->create('\Vsourz\Imagegallery\Model\ResourceModel\ImageGallery\CollectionFactory')->create()->addFieldToFilter('image_id', ['in' => $imageIds]);
                
                foreach ($imageCategoryCollection as $imagecategory) {
                    $imagecategory->delete();
                }

                $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', count($imageIds))
                );
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('*/*/');
    }
}
