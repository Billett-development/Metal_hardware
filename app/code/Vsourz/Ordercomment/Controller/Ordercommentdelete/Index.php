<?php
/**
 *
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vsourz\Ordercomment\Controller\Ordercommentdelete;

class Index extends \Vsourz\Ordercomment\Controller\Index
{
    public function execute()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
         $result = $objectManager->create('\Magento\Framework\Controller\Result\JsonFactory')->create();
        $checkoutSession->setOrdercommentsstatus('');
        $checkoutSession->setOrderCommentstext('');

        $result->setData(['success'=>'true']);
       	return $result;
        /*$this->_redirect("checkout");*/
    }
}
