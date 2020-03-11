<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Ibnab\MegaMenu\Helper;

use Magento\Customer\Model\Session as CustomerSession;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Catalog data helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * @var CustomerSession
     */
    protected $_customerSession;
    /**
     * ScopeConfigInterface scopeConfig
     *
     * @var scopeConfig
     */
    protected $scopeConfig;
    /**
     * @param CustomerSession $customerSession
     */
    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        CustomerSession $customerSession
    ) {
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }
    public function allowExtension(){
     return  $this->scopeConfig->getValue('ibnab_mega_config/general/enabledisable', ScopeConfigInterface::SCOPE_TYPE_DEFAULT);
    }  
}
