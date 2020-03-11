<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vsourz\Ordercomment\Controller\Ordercomment;

class Index extends \Vsourz\Ordercomment\Controller\Index
{

    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $result = $objectManager->create('\Magento\Framework\Controller\Result\JsonFactory')->create();


        $success = 0;
        $fileuplaodstatus = 0;
        $ordercommentsstatus = 0;
        $fileuplaodvalue = "";
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');

        $checkoutSession->setOrderCommentsdata(1);
        $checkoutSession->setFileuploadvaluestatus(0);
        $image = $this->getRequest()->getFiles('order_for');
        $Ordercomments = nl2br($this->getRequest()->getPost('order_comments'));

        if ($Ordercomments) {
            $checkoutSession->setOrderCommentstext($Ordercomments);

            $ordercommentsstatus = 1;
            $checkoutSession->setOrdercommentsstatus($ordercommentsstatus);
            $success = 1;
        } else {
            $Ordercomments = "";
            $checkoutSession->setOrderCommentstext($checkoutSession->getOrderCommentstext());
            $ordercommentsstatus = 1;
            $checkoutSession->setOrdercommentsstatus($ordercommentsstatus);
        }

        if (isset($image)) {

                $fileName = $image['name'];
                $newfileName = $image['name'];

                $fileName= str_replace(' ', '_', $fileName);
                /*Added Time function for unique name*/
                $File_name = '';
                $File_ext = '';
                $File_name = pathinfo($fileName, PATHINFO_FILENAME).time();
                $File_ext = pathinfo($fileName, PATHINFO_EXTENSION);

                if($File_name && $File_ext) {
                    $fileName = $File_name.'.'.$File_ext;
                }

                $checkoutSession->setOrderForFile($fileName);

                $mediaDirectory = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);

            try {
                    $OrdercommentFiletype = $objectManager
                    ->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentFiletype();
                    $uploader = $this->_objectManager
                    ->create('\Magento\MediaStorage\Model\File\UploaderFactory')->create(['fileId'=> $image]);

                    if ($OrdercommentFiletype) {
                       $OrdercommentFiletypeArray = explode(',',$OrdercommentFiletype);
                       $uploader->setAllowedExtensions($OrdercommentFiletypeArray);
                    } else {
                       $uploader->setAllowedExtensions(['jpg','jpeg','gif','png','txt','exe','psd','csv','doc']);
                    }
                    $uploader->setAllowRenameFiles(true);
                    $uploader->setFilesDispersion(true);

                    $uploader->save($mediaDirectory->getAbsolutePath('vsourz/orderfileattachment'));
                   /*$uploader->save($mediaDirectory->getAbsolutePath('vsourz/orderfileattachment'));*/

                    $fileuplaodstatus = 1;
                    $fileuplaodvalue = $fileName;
                    $checkoutSession->setFileuploadstatus($fileuplaodstatus);
                    $checkoutSession->setFileuploadvalue($fileuplaodvalue);
                    $checkoutSession->setFileuploadvaluestatus(0);

                    $success = 1;
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    $checkoutSession->setFileuploadstatus('');
                    $checkoutSession->setFileuploadvalue('');
                    $checkoutSession->setFileuploadvaluestatus(1);
                    /*$this->_redirect("checkout");*/
                }
            }
        } else {
            $checkoutSession->setOrderForFile('');
            $fileuplaodstatus = 1;
            $checkoutSession->setFileuploadstatus($fileuplaodstatus);
            $checkoutSession->setFileuploadvalue($checkoutSession->getFileuploadvalue());
            $checkoutSession->setFileuploadvaluestatus(0);
            /*$this->_redirect("checkout");*/
        }
        if($success == 1){

            if(isset($newfileName) && !empty($newfileName)){
                $imagename = $newfileName;
            }else{
                $imagename = $checkoutSession->getFileuploadvalue();

            }
            $result->setData(['success'=>'true','comment' => $checkoutSession->getOrderCommentstext(),'ordercommentstatus' =>$checkoutSession->getOrdercommentsstatus(),'filename' => $imagename,'fileuploadstauts' =>$checkoutSession->getFileuploadstatus()]);
        }else{
            $result->setData(['success'=>'false']);
            /*$this->_redirect("checkout");*/
        }
        return $result;
    }
}
