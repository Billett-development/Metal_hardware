<?php

namespace Meetanshi\Callforprice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Callforprice extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('meetanshi_callforprice', 'id');
    }
}
