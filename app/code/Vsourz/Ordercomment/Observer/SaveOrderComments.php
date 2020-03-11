<?php

namespace Vsourz\Ordercomment\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class SaveOrderComments implements ObserverInterface
{
    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectmanager
    ) {
        $this->_objectManager = $objectmanager;
    }

    public function execute(EventObserver $observer)
    {
        $order = $observer->getOrder();
        $quoteRepository = $this->_objectManager->create('Magento\Quote\Model\QuoteRepository');
        if ($order->getQuoteId()) {
            //Get session value for order_for file data
            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
            $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
            $getOrderCommentsdata = $checkoutSession->getOrderCommentsdata(1);
            if ($getOrderCommentsdata == 1) {
                if ($checkoutSession->getFileuploadvalue()) {
                    $order->setOrderFor($checkoutSession->getFileuploadvalue());
                }
                if ($checkoutSession->getOrderCommentstext()) {
                    $order->setOrderComments($checkoutSession->getOrderCommentstext());
                }
            } else {
                    $order->setOrderFor('');
                    $order->setOrderComments('');
                    $checkoutSession->setFileuploadstatus('');
                    $checkoutSession->setOrdercommentsstatus('');
                    $checkoutSession->setFileuploadvalue('');
            }
        }
        $checkoutSession->setFileuploadstatus('');
        $checkoutSession->setOrdercommentsstatus('');
        $checkoutSession->setFileuploadvalue('');
        $checkoutSession->setOrderCommentstext('');
        return $this;
    }
}
