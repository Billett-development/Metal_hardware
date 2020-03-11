<?php

namespace Meetanshi\Callforprice\Block;

use Magento\Customer\Model\Session;
use Magento\Directory\Block\Data;
use Magento\Framework\App\Http\Context as HttpContext;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Callforpricepopup extends Template
{
    private $directoryBlock;
    private $isScopePrivate;
    private $customerSession;
    protected $httpContext;

    public function __construct(
        Data $directoryBlock,
        Context $context,
        HttpContext $httpContext,
        Session $session,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->isScopePrivate = true;
        $this->directoryBlock = $directoryBlock;
        $this->customerSession = $session;
        $this->httpContext = $httpContext;
    }

    public function customerLoggedIn()
    {
        return (bool)$this->httpContext->getValue(\Magento\Customer\Model\Context::CONTEXT_AUTH);
    }

    public function getAvailableCountries()
    {
        $country = $this->directoryBlock->getCountryHtmlSelect();
        return $country;
    }

    public function getLogginCustomerName()
    {
        if ($this->customerLoggedIn()) {
            $customer = $this->customerSession->getCustomer();
            return $customer->getName();
        } else {
            return '';
        }
    }

    public function getLogginCustomerEmail()
    {
        if ($this->customerLoggedIn()) {
            return $this->customerSession->getCustomer()->getEmail();
        } else {
            return '';
        }
    }
}
