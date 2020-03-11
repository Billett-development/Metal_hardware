<?php

/**
 * Vsourz
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Vsourz.com license that is
 * available through the world-wide-web at this URL:
 * http://www.vsourz.com/license-agreement.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Vsourz
 * @package     Vsourz_Imagegallery
 * @copyright   Copyright (c) 2012 Vsourz (http://www.vsourz.com/)
 * @license     http://www.vsourz.com/license-agreement.html
 */

namespace Vsourz\Imagegallery\Controller\Adminhtml\Image;

use Vsourz\Imagegallery\Controller\Adminhtml\Image;

/**
 *
 *
 * @category Vsourz
 * @package  Vsourz_Imagegallery
 * @module   Pdfinvoiceplus
 * @author   Vsourz Developer
 */
class Delete extends Image
{
    /**
     * Delete action.
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('image_id');
        if ($id) {
            try {
                /** @var \Vsourz\Imagegallery\Model\Image $model */
                $model = $this->_objectManager->create('Vsourz\Imagegallery\Model\Image');
                $model->load($id);
                $image_name = $model->getData('image_title');
                $model->delete();
                $this->messageManager->addSuccess(__('You deleted the item.'));

                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a item to delete.'));

        return $resultRedirect->setPath('*/*/');
    }
}
