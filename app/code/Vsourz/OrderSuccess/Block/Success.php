<?php

/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Vsourz\OrderSuccess\Block;

class Success extends \Magento\Checkout\Block\Onepage\Success
{

    public function getObjectManager()
    {
        return \Magento\Framework\App\ObjectManager::getInstance();
    }

    public function _prepareLayout()
    {
    	$this->getLayout()->getBlock('checkout.success')->unsetChild('order.success.additional.info');
		$this->getLayout()->getBlock('checkout.success')->unsetChild('downloadable.checkout.success');
        $this->getLayout()->unsetElement('checkout.success');
        $this->getLayout()->unsetElement('checkout.registration');
    }
}
