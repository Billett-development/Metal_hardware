<?php

namespace Vsourz\Imagegallery\Model;

class Image extends \Magento\Framework\Model\AbstractModel
{
    const BASE_MEDIA_PATH = 'vsourz/imagegallery/images';
   
    protected $_categoryCollection;

    protected $_imageCategoryFactory;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Vsourz\Imagegallery\Model\ResourceModel\Image $resource,
        \Vsourz\Imagegallery\Model\ImageGalleryFactory $imageCategoryFactory,
        \Vsourz\Imagegallery\Model\ResourceModel\Image\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
        $this->_imageCategoryFactory = $imageCategoryFactory;
    }

    public function getExtraMethod()
    {
        return "Image : Extra Method";
    }

    // public function getCategorysCollections()
    // {
    //     $imageID = $this->getId();
    //     //$imageCategory = $this->_imageCategoryFactory->create();
    // //     return $imageCategory->addFieldToFilter('image_id',$imageID);

    //     $categorys = [];

    //     // $select = $this->getConnection()->select()->from(
    //     //         ['image_category' => $this->getTable('vsourz_imagegallery_image_category')],
    //     //         [
    //     //             'image' => 'super_attribute.image_id',
    //     //             'category' => 'super_attribute.category_id',
    //     //             'position' => 'super_attribute.position'
    //     //         ]
    //     //     );

    //     // $categorys = $this->getConnection()->fetchAll($select);

    //     return  $categorys;

    // }


}
