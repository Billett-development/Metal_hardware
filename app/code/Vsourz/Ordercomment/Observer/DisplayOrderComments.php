<?php

namespace Vsourz\Ordercomment\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class DisplayOrderComments implements ObserverInterface
{

    protected $_objectManager;

    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    public function execute(EventObserver $observer)
    {

        if ($observer->getElementName() == 'order_info')
        {
            $orderShippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingViewBlock->getOrder();
            $orderCommentsBlock = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $orderCommentsBlock->setOrderComments($order->getOrderComments());
            $orderCommentsBlock->setOrderFor($order->getOrderFor());
            $orderCommentsBlock->setTemplate('Vsourz_Ordercomment::order_comments.phtml');
            $html = $observer->getTransport()->getOutput() . $orderCommentsBlock->toHtml();
            $observer->getTransport()->setOutput($html);
        }
    }
}
