<?php
/**
 * @author      WebPanda
 * @package     WebPanda_AutoInvoice
 * @copyright   Copyright (c) WebPanda (https://webpanda-solutions.com/)
 * @license     https://webpanda-solutions.com/license-agreement
 */

namespace WebPanda\AutoInvoice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Data
 * @package WebPanda\AutoInvoice\Helper
 */
class Data extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
        $this->scopeConfig = $context->getScopeConfig();
    }

    /**
     * @return mixed
     */
    public function getOrderTotalThreshold()
    {
        return $this->scopeConfig->getValue('auto_invoice/default/order_total', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if is invoice auto generation enabled
     * @return bool
     */
    public function isEnabledInvoice()
    {
        return $this->scopeConfig->isSetFlag('auto_invoice/default/enabled_invoice', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if is shipment auto generation enabled
     * @return bool
     */
    public function isEnabledShipment()
    {
        return $this->scopeConfig->isSetFlag('auto_invoice/default/enabled_shipment', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if is invoice auto generation email enabled
     * @return bool
     */
    public function isEnabledSendInvoiceMail()
    {
        return $this->scopeConfig->isSetFlag('auto_invoice/default/enabled_send_invoice_mail', ScopeInterface::SCOPE_STORE);
    }

    /**
     * Check if is shipment auto generation email enabled
     * @return bool
     */
    public function isEnabledSendShipmentMail()
    {
        return $this->scopeConfig->isSetFlag('auto_invoice/default/enabled_send_shipment_mail', ScopeInterface::SCOPE_STORE);
    }
}
