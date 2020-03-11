<?php

namespace Vsourz\Imagegallery\Model;

class ImageGallery extends \Magento\Framework\Model\AbstractModel
{

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Vsourz\Imagegallery\Model\ResourceModel\ImageGallery $resource,
        \Vsourz\Imagegallery\Model\ResourceModel\ImageGallery\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

    public function getCategorysCollectionByImageId($imageId){
        $collection = $this->getCollection();
        $collection->addFieldToFilter('main_table.image_id',$imageId);
        $collection->getSelect()->join(array('category' => 'vsourz_imagegallery_category'),'main_table.category_id = category.category_id AND category.status = 1')->order('main_table.position','asc');
        return $collection;
    }

}
