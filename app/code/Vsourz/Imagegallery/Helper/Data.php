<?php
namespace Vsourz\Imagegallery\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLED = 'imagegallery/general/enabled';	
	protected $_scopeConfig;	
    protected $_storeManager;
    protected $_backendUrl;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
         \Magento\Backend\Model\UrlInterface $backendUrl
    ) {
		$this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
        $this->_storeManager = $storeManager;
        $this->_backendUrl = $backendUrl;
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
     * Get Category Title
     *
     * @return string|null
     */
	public function getCategorytitle()
    {
        $enabled_category_title = $this->scopeConfig->getValue('imagegallery/general/enabled_category_title',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
	
		return $enabled_category_title;
    }	
	/**
     * Get Category Description
     *
     * @return string|null
     */
	public function getCategorydescription()
    {
        $enabled_category_desc = $this->scopeConfig->getValue('imagegallery/general/enabled_category_desc',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);	
		return $enabled_category_desc;
    }	
	/**
     * Get Image Title
     *
     * @return string|null
     */
	public function getImagetitle()
    {
        $enabled_image_title = $this->scopeConfig->getValue('imagegallery/general/enabled_image_title',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);	
		return $enabled_image_title;
    }	
	/**
     * Get Image Description
     *
     * @return string|null
     */
	public function getImagedescription()
    {
        $enabled_image_description = $this->scopeConfig->getValue('imagegallery/general/enabled_image_description',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);			
		return $enabled_image_description;
    }	
    public function getBaseUrlMedia($path = '', $secure = false)
    {
        return $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, $secure) . $path;
    }
    public function getImageGallerysGridUrl()
    {
        return $this->_backendUrl->getUrl('imagegalleryadmin/image/categorys', ['_current' => true]);
    }
}
