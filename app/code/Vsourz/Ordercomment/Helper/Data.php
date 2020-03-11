<?php
namespace Vsourz\Ordercomment\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLED = 'ordercomment/general/enabled';

    protected $_scopeConfig;

    public $_storeManager;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
          $this->_storeManager=$storeManager;
    }

    /**
     * Check if enabled
     *
     * @return string|null
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Order comment
     *
     * @return string|null
     */
    public function getOrdercomment()
    {
        $Ordercomment = $this->scopeConfig
        ->getValue('ordercomment/general/order_comments', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $Ordercomment;
    }

    /**
     * Get Order comment title
     *
     * @return string|null
     */
    public function getOrdercommenttitle()
    {
        $Ordercommenttitle = $this->scopeConfig
        ->getValue('ordercomment/general/order_comment_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $Ordercommenttitle;
    }

    /**
     * Get File upload
     *
     * @return string|null
     */
    public function getOrderfileupload()
    {
         $Order_file_upload = $this->scopeConfig
         ->getValue('ordercomment/general/order_file_upload', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $Order_file_upload;
    }

    /**
     * Get File upload Status
     *
     * @return string|null
     */
    public function getOrderfileuploadstatus()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');

        if ($checkoutSession->getFileuploadstatus()) {
            $Order_file_upload_status = $checkoutSession->getFileuploadstatus();
        } else {
            $Order_file_upload_status = 0;
        }
        return $Order_file_upload_status;
    }

    /**
     * Get Order Comments Status
     *
     * @return string|null
     */
    public function getOrdercommentsstatus()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');

        if ($checkoutSession->getOrdercommentsstatus()) {
            $Order_comments_status = $checkoutSession->getOrdercommentsstatus();
        } else {
            $Order_comments_status = 0;
        }
        return $Order_comments_status;
    }

    /**
     * Get File upload Value
     *
     * @return string|null
     */
    public function getOrderfileuploadvalue()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');

        if ($checkoutSession->getFileuploadvalue()) {
            $Order_file_upload_value = $checkoutSession->getFileuploadvalue();
        } else {
            $Order_file_upload_value = "";
        }
        return $Order_file_upload_value;
    }

     /**
      * Get Order comment text title
      *
      * @return string|null
      */
    public function getOrdercommenttexttitle()
    {
        $Ordercommenttexttitle = $this->scopeConfig
        ->getValue('ordercomment/general/order_comment_text_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $Ordercommenttexttitle;
    }

    /**
     * Get Order file text title
     *
     * @return string|null
     */
    public function getOrderfiletexttitle()
    {
        $Orderfiletexttitle = $this->scopeConfig
        ->getValue('ordercomment/general/order_comment_file_title', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $Orderfiletexttitle;
    }

        /**
         * Get Base url
         *
         * @return string|null
         */
    public function getBaseurlordercomment()
    {

        $Baseurl =  $this->_storeManager->getStore()->getBaseUrl().'checkout/ordercomment/index';

        return $Baseurl;
    }
    public function getOrdercommentdelete()
    {

        $Baseurl =  $this->_storeManager->getStore()->getBaseUrl().'checkout/Ordercommentdelete/Index';

        return $Baseurl;
    }
    public function getOrderfiledelete()
    {

        $Baseurl =  $this->_storeManager->getStore()->getBaseUrl().'checkout/Orderfiledelete/Index';

        return $Baseurl;
    }

        /**
         * Get tOrdercommentField Value
         *
         * @return string|null
         */
    public function getOrdercommentField()
    {

        $getOrdercommentField = $this->scopeConfig
        ->getValue('ordercomment/general/order_comments_field_required', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $getOrdercommentField;
    }

        /**
         * Get OrdercommentFile Value
         *
         * @return string|null
         */
    public function getOrdercommentFile()
    {

        $getOrdercommentFile = $this->scopeConfig
        ->getValue('ordercomment/general/order_comments_file_required', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $getOrdercommentFile;
    }

    /**
     * Get OrdercommentFileType Value
     *
     * @return string|null
     */
    public function getOrdercommentFiletype()
    {

        $getOrdercommentFiletype = $this->scopeConfig
        ->getValue('ordercomment/general/order_comments_file_type', \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $getOrdercommentFiletype;
    }
}
