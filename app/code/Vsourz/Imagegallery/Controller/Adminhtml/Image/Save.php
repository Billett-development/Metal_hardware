<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;


class Save extends \Vsourz\Imagegallery\Controller\Adminhtml\Image
{

    public function execute()
    {

		$image = null;

        $resultRedirect = $this->resultRedirectFactory->create();
        $formPostValues = $this->getRequest()->getPostValue();
		
	    $image = $this->getRequest()->getFiles('image_photo');
     //	print_r($formPostValues); exit;
		$formPostValues['imagedata'] = $formPostValues;
		
        if (isset($formPostValues['imagedata'])) {
		
            $imageData = $formPostValues['imagedata'];
            $imageId = isset($imageData['image_id']) ? $imageData['image_id'] : null;
			
			  if (isset($image) && isset($image['name']) && $image['name'] != null) {
				
                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

                $file = $this->_objectManager->create('\Magento\Framework\Filesystem\Driver\File');

                if(isset($imageData['image_photo']['delete']) && $imageData['image_photo']['delete'] == 1){
                    $deleteurl = $mediaDirectory->getAbsolutePath().$imageData['image_photo']['value'];
                    if ($file->isExists($deleteurl))  {
                        $file->deleteFile($deleteurl);
                        $imageData['image_photo'] = null;
                    }
					
                }
				

                try {
          
					$uploader = $this->_objectManager->create('\Magento\MediaStorage\Model\File\Uploader',['fileId'=>'image_photo']);
					
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $imageAdapter = $this->_objectManager->get('Magento\Framework\Image\AdapterFactory')->create();
                    $uploader->addValidateCallback('image_photo', $imageAdapter, 'validateUploadFile');
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);
               
                    $result = $uploader->save($mediaDirectory->getAbsolutePath(\Vsourz\Imagegallery\Model\Image::BASE_MEDIA_PATH));
                    $imageData['image_photo'] = \Vsourz\Imagegallery\Model\Image::BASE_MEDIA_PATH.$result['file'];

                } catch (\Exception $e) {

                    if ($e->getCode() == 0) {
                        $this->messageManager->addError($e->getMessage());
					    return $resultRedirect->setPath('*/*/');
                    }
                }


            } else {

                if (isset($imageData['image_photo']) && isset($imageData['image_photo']['value'])) {
                    if (isset($imageData['image_photo']['delete'])) {
                        $imageData['image_photo'] = null;
                        $imageData['delete_image'] = true;
                    } elseif (isset($imageData['image_photo']['value'])) {
                        $imageData['image_photo'] = $imageData['image_photo']['value'];
                    } else {
					
                        $imageData['image_photo'] = null;
                    }
                }
            }
			
            $model = $this->_imageFactory->create();
            $model->load($imageId);

           //  if($imageId == null){
               // $imageData['created_at'] = date("Y-m-d H:i:s");
           // }
            
           // $imageData['updated_at'] = date("Y-m-d H:i:s");
            $model->setData($imageData);

		    try {
		  
                $m   = $model->save();
                $md  = $m->getData();
                $imageData['image_id'] = $md['image_id'];
            /* Parse Category */

            $selected_list = array();

            if(isset($formPostValues['selectedCategorys'])){
				
               $selected = (!empty($formPostValues['selectedCategorys']))? $formPostValues['selectedCategorys'] : array();
              // $position = (!empty($formPostValues['position']))? $formPostValues['position'] : array();

                foreach ($selected as $key => $value) {
                  //  if(isset($position[$value])){
                       $selected_list[$value]['image_id'] = $imageData['image_id'];
                       $selected_list[$value]['category_id'] = $value ;
                       $selected_list[$value]['action'] = "create";
                       //$selected_list[$value]['position'] = $position[$value];
                 //   }
                }

            }
		
            /* Get Categorys of current Image */

            try {
				
			if(isset($imageData['image_id'])){

                $categorys_list =array();
                $image_categorys_list = $selected_list;

                $imageCategorys = $this->_objectManager->create('\Vsourz\Imagegallery\Model\ImageGalleryFactory')->create();
                $categorys = $imageCategorys->load(null)->getCollection()->addFieldToFilter('main_table.image_id',$imageData['image_id']);

                if(!empty($categorys->getData())){
                    foreach ($categorys->getData() as $key => $value) {
                        if(isset($selected_list[$value['category_id']])){

                         //   if($value['position'] != $position[$value['category_id']]){
                                $categorys_list[$value['category_id']]['image_category_id'] = $value['image_category_id'];
                                $categorys_list[$value['category_id']]['image_id'] = $imageData['image_id'];
                                $categorys_list[$value['category_id']]['category_id'] = $value['category_id'] ;
                                $categorys_list[$value['category_id']]['action'] = "update";
                              //  $categorys_list[$value['category_id']]['position'] = $position[$value['category_id']];

                                if(isset($categorys_list[$value['category_id']])){
                                    $image_categorys_list[$value['category_id']] = $categorys_list[$value['category_id']];
                                }

                          //  }else{
                                unset($image_categorys_list[$value['category_id']]);
                         //   }

                        }else{
                           $categorys_list[$value['category_id']]['image_category_id'] = $value['image_category_id'];
                           $categorys_list[$value['category_id']]['image_id'] = $imageData['image_id'];
                           $categorys_list[$value['category_id']]['category_id'] = $value['category_id'] ;
                           $categorys_list[$value['category_id']]['action'] = "delete";
                          // $categorys_list[$value['category_id']]['position'] = $position[$value['category_id']];

                            if(isset($categorys_list[$value['category_id']])){
                                $image_categorys_list[$value['category_id']] = $categorys_list[$value['category_id']];
                            }

                        }
                    }
                }

                foreach ($image_categorys_list as $key => $row) {

                    $imageCategory = $this->_objectManager->create('\Vsourz\Imagegallery\Model\ImageGalleryFactory')->create();

                    switch ($row['action']){
                        case 'create':
                            $list['image_id'] = $row['image_id'];
                            $list['category_id'] = $row['category_id'];
                           // $list['position'] = $row['position'];
                            $list['created_at'] = date("Y-m-d H:i:s");
                            $list['updated_at'] = date("Y-m-d H:i:s");
                            if (!empty($list)) {
                                $imageCategory->load(null);
                                $imageCategory->setData($list);
                                $imageCategory->save();
                            }
                        break;
                        case 'update':
                            $list['image_category_id'] = $row['image_category_id'];
                            $list['image_id'] = $row['image_id'];
                            $list['category_id'] = $row['category_id'];
                           // $list['position'] = $row['position'];
                            $list['updated_at'] = date("Y-m-d H:i:s");

                            if (!empty($list)) {
                                $imageCategory->load($row['image_category_id']);
                                $imageCategory->setData($list);
                                $imageCategory->save();
                            }
                        break;
                        case 'delete':
                            $imageCategory->load($row['image_category_id']);
                            $imageCategory->delete();
                        break;
                    }
                }
			  }
            } catch (\Exception $e) {
               //$this->messageManager->addException($e, __('Something went wrong while saving categorys of the image.'));
            }

          
                $this->messageManager->addSuccess(__('The image has been saved.'));
                $this->_getSession()->setFormData(false);

                return $this->_getBackResultRedirect($resultRedirect, $model->getId());
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }

            $this->_getSession()->setFormData($formPostValues);

            return $resultRedirect->setPath('*/*/edit', [static::PARAM_CRUD_ID => $imageId]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
