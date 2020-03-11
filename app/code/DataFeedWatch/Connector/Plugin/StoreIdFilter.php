<?php
/**
 * Created by Q-Solutions Studio
 * Date: 28.11.2019
 *
 * @category    DataFeedWatch
 * @package     DataFeedWatch_Connector
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace DataFeedWatch\Connector\Plugin;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Store\Model\Store;

class StoreIdFilter
{
    /**
     * @method aroundAddAttributeToFilter
     * @param  Collection                     $subject
     * @param  Closure                        $proceed
     * @param  array|string|AbstractAttribute $attribute
     * @param  array|null                     $condition
     * @param  string                         $joinType
     * @return Collection
     */
    public function aroundAddAttributeToFilter(Collection $subject, \Closure $proceed, $attribute, $condition = null, $joinType = 'inner')
    {
        if (is_array($attribute)) {
            foreach ($attribute as $index => $attributeData) {
                if ($attributeData['attribute'] == 'store_id' && isset($attributeData['eq'])) {
                    $subject->addStoreFilter($attributeData['eq']);
                    unset($attribute[$index]);
                    break;
                }
            }

            if (empty($attribute)) {
                return $subject;
            }
        }

        if (is_string($attribute) && $attribute == 'store_id') {
            if (is_array($condition) && isset($condition['eq'])) {
                $subject->addStoreFilter($condition['eq']);
            } else if (is_int($condition) || is_string($condition) || $condition instanceof Store) {
                $subject->addStoreFilter($condition);
            }

            return $subject;
        }

        return $proceed($attribute, $condition, $joinType);
    }
}
