<?php

namespace Meetanshi\Callforprice\Plugin\Catalog\Pricing\Price;

use Magento\Catalog\Pricing\Price\TierPrice as CatalogTierPrice;
use Meetanshi\Callforprice\Helper\Data as HelperData;

class TierPrice
{
    protected $helper;

    public function __construct(HelperData $helper)
    {
        $this->helper = $helper;
    }

    public function afterGetTierPriceList(CatalogTierPrice $subject, $result)
    {
        if ($this->helper->isEnabled()) {
            $selectedArea = $this->helper->isEnableFor();

            if ($selectedArea == 'category') {
                if (!$this->helper->isAllowCustomerGroups()) {
                    $showInCategory = $this->helper->showCategories();
                    if (!$showInCategory) {
                        return $result;
                    } else {
                        return [];
                    }
                } elseif ($this->helper->isAllowCustomerGroups()) {
                    $showInCategory = $this->helper->showCategories();
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if (!$showInCategory && !$customerGroupIds) {
                        return $result;
                    } else {
                        return [];
                    }
                }
            } elseif ($selectedArea == 'product') {
                $callForText = $this->helper->getProductText($subject->getProduct()->getId());

                if ($callForText && !$this->helper->isAllowCustomerGroups()) {
                    if (!$subject->getProduct()->getId()) {
                        return $result;
                    } else {
                        return [];
                    }
                } elseif ($callForText && $this->helper->isAllowCustomerGroups()) {
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if ((!$subject->getProduct()->getId()) && $customerGroupIds) {
                        return $result;
                    } else {
                        return [];
                    }
                } else {
                    return $result;
                }
            } else {
                if ($this->helper->isAllowCustomerGroups()) {
                    $customerGroupIds = $this->helper->showCustomerGroups();
                    if (!$customerGroupIds) {
                        return $result;
                    } else {
                        return [];
                    }
                }
                return [];
            }
        } else {
            return $result;
        }
    }
}
