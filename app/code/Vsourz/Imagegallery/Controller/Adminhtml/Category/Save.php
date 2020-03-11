<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

use Vsourz\Imagegallery\Model\Category;

class Save extends \Vsourz\Imagegallery\Controller\Adminhtml\Category
{

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();
        $image = $this->getRequest()->getFiles('image');
		$thumbnail_image = $this->getRequest()->getFiles('thumbnail_image');

        if (!empty($formPostValues)) {

            $categoryData = $formPostValues;
            $categoryId = isset($categoryData['category_id']) ? $categoryData['category_id'] : null;

            if (isset($image) && isset($image['name']) && $image['name'] != null) {

                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

                $file = $this->_objectManager->create('\Magento\Framework\Filesystem\Driver\File');
			
                if(isset($categoryData['image']['delete']) && $categoryData['image']['delete'] == 1){
                    $deleteurl = $mediaDirectory->getAbsolutePath().$categoryData['image']['value'];
                    if ($file->isExists($deleteurl))  {
                        $file->deleteFile($deleteurl);
                        $categoryData['image'] = null;
                    }
                }

                try {
           
                    $uploader = $this->_objectManager->create('\Magento\MediaStorage\Model\File\Uploader',['fileId'=>'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                    $uploader->addValidateCallback('image', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
                    
                    $result = $uploader->save($mediaDirectory->getAbsolutePath(\Vsourz\Imagegallery\Model\Category::BASE_MEDIA_PATH));
                    $categoryData['image'] = \Vsourz\Imagegallery\Model\Category::BASE_MEDIA_PATH.$result['file'];



                } catch (\Exception $e) {

                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }


            } else {

                if (isset($categoryData['image']) && isset($categoryData['image']['value'])) {
                    if (isset($categoryData['image']['delete'])) {
                        $categoryData['image'] = null;
                        $categoryData['delete_image'] = true;
                    } elseif (isset($categoryData['image']['value'])) {
                        $categoryData['image'] = $categoryData['image']['value'];
                    } else {
                        $categoryData['image'] = null;
                    }
                }
            }
			
			// thumbnail image save
			
			 /* if (isset($thumbnail_image) && isset($thumbnail_image['name']) && $thumbnail_image['name'] != null) {

                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

                $thumbnail_file = $this->_objectManager->create('\Magento\Framework\Filesystem\Driver\File');
			
                if(isset($categoryData['thumbnail_image']['delete']) && $categoryData['thumbnail_image']['delete'] == 1){
                    $thumbnail_deleteurl = $mediaDirectory->getAbsolutePath().$categoryData['thumbnail_image']['value'];
                    if ($thumbnail_file->isExists($thumbnail_deleteurl))  {
                        $thumbnail_file->deleteFile($thumbnail_deleteurl);
                        $categoryData['thumbnail_image'] = null;
                    }
                }

                try {
           
                    $thumbnail_uploader = $this->_objectManager->create('\Magento\MediaStorage\Model\File\Uploader',['fileId'=>'thumbnail_image']);
                    $thumbnail_uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                    $thumbnail_uploader->addValidateCallback('thumbnail_image', $imageAdapter, 'validateUploadFile');
                    $thumbnail_uploader->setAllowRenameFiles(true);
                    $thumbnail_uploader->setFilesDispersion(true);
                    
                    $thumbnail_result = $thumbnail_uploader->save($mediaDirectory->getAbsolutePath(\Vsourz\Imagegallery\Model\Category::BASE_MEDIA_PATH));
                    $categoryData['thumbnail_image'] = \Vsourz\Imagegallery\Model\Category::BASE_MEDIA_PATH.$thumbnail_result['file'];



                } catch (\Exception $e) {

                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
                    }
                }


            } else {

                if (isset($categoryData['thumbnail_image']) && isset($categoryData['thumbnail_image']['value'])) {
                    if (isset($categoryData['thumbnail_image']['delete'])) {
                        $categoryData['thumbnail_image'] = null;
                        $categoryData['delete_thumbnail_image'] = true;
                    } elseif (isset($categoryData['thumbnail_image']['value'])) {
                        $categoryData['thumbnail_image'] = $categoryData['thumbnail_image']['value'];
                    } else {
                        $categoryData['thumbnail_image'] = null;
                    }
                }
            } */


            $model = $this->_categoryFactory->create();
            $model->load($categoryId);

            if($categoryId == null){
                 $categoryData['created_at'] = date("Y-m-d H:i:s");
            }

            $categoryData['updated_at'] = date("Y-m-d H:i:s");

            $model->setData($categoryData);
            
            try {

                $model->save();
                $this->messageManager->addSuccess(__('The category has been saved.'));
                $this->_getSession()->setFormData(false);
                return $this->_getBackResultRedirect($resultRedirect, $model->getId());

            } catch (\Exception $e) {

                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the category.'));

            }

            $this->_getSession()->setFormData($formPostValues);

            return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $categoryId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
