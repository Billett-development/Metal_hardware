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
 * @package     Vsourz_Contactus
 * @copyright   Copyright (c) 2012 Vsourz (http://www.vsourz.com/)
 * @license     http://www.vsourz.com/license-agreement.html
 */

namespace Vsourz\Imagegallery\Controller\Adminhtml\Category;

use Vsourz\Imagegallery\Controller\Adminhtml\Category;

/**
 *
 *
 * @category Vsourz
 * @package  Vsourz_Imagegallery
 * @module   Pdfinvoiceplus
 * @author   Vsourz Developer
 */
class Delete extends Category
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
        $id = $this->getRequest()->getParam('category_id');
        if ($id) {
            try {
                /** @var \Vsourz\Imagegallery\Model\Category $model */
                $model = $this->_objectManager->create('Vsourz\Imagegallery\Model\Category');
                $model->load($id);
                $category_name = $model->getData('title');
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
