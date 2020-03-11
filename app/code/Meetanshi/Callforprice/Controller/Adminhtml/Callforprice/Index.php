<?php

namespace Meetanshi\Callforprice\Controller\Adminhtml\Callforprice;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Meetanshi_Callforprice::callforprice');
        $resultPage->getConfig()->getTitle()->prepend((__('Call For Price Inquiries')));
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Meetanshi_Callforprice::callforprice');
    }
}
