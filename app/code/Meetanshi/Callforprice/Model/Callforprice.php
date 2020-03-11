<?php

namespace Meetanshi\Callforprice\Model;

use Magento\Framework\Model\AbstractModel;

class Callforprice extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Meetanshi\Callforprice\Model\ResourceModel\Callforprice');
    }
}
