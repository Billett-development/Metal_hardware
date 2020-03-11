<?php

namespace Vsourz\Imagegallery\Model;

class Category extends \Magento\Framework\Model\AbstractModel
{
    const BASE_MEDIA_PATH = 'vsourz/imagegallery/images';

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Vsourz\Imagegallery\Model\ResourceModel\Category $resource,
        \Vsourz\Imagegallery\Model\ResourceModel\Category\Collection $resourceCollection
    ) {
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection
        );
    }

}
