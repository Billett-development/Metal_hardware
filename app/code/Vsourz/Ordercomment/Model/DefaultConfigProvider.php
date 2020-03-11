<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Vsourz\Ordercomment\Model;

use Magento\Checkout\Model\ConfigProviderInterface;

class DefaultConfigProvider implements ConfigProviderInterface
{

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectmanager
    ) {
        $this->_objectManager = $objectmanager;
    }

    public function getConfig()
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $checkoutSession = $objectManager->create('\Magento\Checkout\Model\Session');
        // Get system config value from helper
        $isEnabled = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->isEnabled();
        $isEnabledOrdercomment = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercomment();
        $isEnabledFileupload = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrderfileupload();
        $Fileuploadstatus = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrderfileuploadstatus();
        $Ordercommentsstatus = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentsstatus();
        $Fileuploadvalue = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrderfileuploadvalue();
        $Ordercommenttitle = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommenttitle();
        $Ordercommenttexttitle = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')
        ->getOrdercommenttexttitle();
        $Orderfiletexttitle = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrderfiletexttitle();
        $Ordercommentbaseurl = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getBaseurlordercomment();
        $ordercommentdelete = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentdelete();
        $Orderfiledelete = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrderfiledelete();
        $OrdercommentField = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentField();
        $OrdercommentFile = $this->_objectManager->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentFile();
        $Order_comments_file_type = $this->_objectManager
        ->create('Vsourz\Ordercomment\Helper\Data')->getOrdercommentFiletype();

        $output['enabled'] = $isEnabled;
        $output['enabledordercomment'] = $isEnabledOrdercomment;
        $output['enabledfileupload'] = $isEnabledFileupload;
        $output['fileuploadstatus'] = $Fileuploadstatus;
        $output['ordercommentsstatus'] = $Ordercommentsstatus;
        $output['fileuploadvalue'] = $Fileuploadvalue;
        $output['ordercommenttitle'] = $Ordercommenttitle;
        $output['ordercommenttexttitle'] = $Ordercommenttexttitle;
        $output['orderfiletexttitle'] = $Orderfiletexttitle;
        $output['ordercommentbaseurl'] = $Ordercommentbaseurl;
        $output['ordercommentfield'] = $OrdercommentField;
        $output['ordercommentfieldno'] = $OrdercommentField;
        $output['ordercommentfile'] = $OrdercommentFile;
        $output['ordercommentfileno'] = $OrdercommentFile;
        $output['ordercommentdelete'] = $ordercommentdelete;
        $output['orderfiledelete'] = $Orderfiledelete;
        $output['getordercommentstext'] = $checkoutSession->getOrderCommentstext();
        $output['order_comments_file_type'] = "Allow file : ".$Order_comments_file_type;

        if ($checkoutSession->getFileuploadvaluestatus()) {
            $Fileuploadvaluestatus = $checkoutSession->getFileuploadvaluestatus();
            if ($output['fileuploadvalue'] == "" && $Fileuploadvaluestatus == 1) {
                    $output['fileuploadvaluestatus'] = "Disallowed file type";
            } else {
                    $output['fileuploadvaluestatus'] = "";
            }
        }
        return $output;
    }
}
