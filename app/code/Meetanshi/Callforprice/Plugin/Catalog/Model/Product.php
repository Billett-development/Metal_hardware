<?php

namespace Meetanshi\Callforprice\Plugin\Catalog\Model;

use Magento\Catalog\Model\Product as CatalogProduct;
use Meetanshi\Callforprice\Helper\Data as HelperData;

class Product
{
    protected $helper;

    public function __construct(HelperData $helper)
    {
        $this->helper = $helper;
    }

    public function afterIsSaleable(CatalogProduct $product, $result)
    {
        if ($this->helper->isEnabled()) {
            if ($this->helper->isEnableFor() == 'global') {
                if (!$this->helper->isAllowCustomerGroups()) {
                    return [];
                }elseif ($this->helper->isAllowCustomerGroups()){
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if ($customerGroupIds) {
                        return [];
                    } else {
                        return $result;
                    }
                }
            }elseif ($this->helper->isEnableFor() != 'product') {
                if ($this->helper->isAllowCategories() && !$this->helper->isAllowCustomerGroups()) {
                    $showInCategory = $this->helper->showPrdCategories($product->getId());
                    if ($showInCategory) {
                        return [];
                    } else {
                        return $result;
                    }
                } elseif ($this->helper->isAllowCustomerGroups() && !$this->helper->isAllowCategories()) {
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if ($customerGroupIds) {
                        return [];
                    } else {
                        return $result;
                    }
                } elseif ($this->helper->isAllowCustomerGroups() && $this->helper->isAllowCategories()) {
                    $showInCategory = $this->helper->showPrdCategories($product->getId());
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if ($customerGroupIds && $showInCategory) {
                        return [];
                    } else {
                        return $result;
                    }
                }
                return $result;
            } else {
                $callForText = $this->helper->getProductText($product->getId());
                if ($this->helper->isAllowCustomerGroups() && $callForText) {
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if ($customerGroupIds && $callForText) {
                        return [];
                    } else {
                        return $result;
                    }
                } elseif (!$this->helper->isAllowCustomerGroups() && $callForText) {
                    if ($this->helper->getProductText($product->getId())) {
                        return [];
                    } else {
                        return $result;
                    }
                } else {
                    return $result;
                }
            }
        } else {
            return $result;
        }
    }
}
