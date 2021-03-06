<?php
/**
 * Magiccart 
 * @category    Magiccart 
 * @copyright   Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license     http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2016-01-05 10:40:51
 * @@Modify Date: 2016-04-19 18:03:00
 * @@Function:
 */

namespace Magiccart\Alothemes\Controller\Adminhtml\Export;

use Magento\Framework\App\Filesystem\DirectoryList;

class Magicmenu extends \Magiccart\Alothemes\Controller\Adminhtml\Action
{

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    // public function execute()
    // {
    //     $resultLayout = $this->_resultLayoutFactory->create();

    //     return $resultLayout;
    // }

    public function execute()
    {
        $theme_path = $this->getRequest()->getParam('theme_path');
        if($theme_path) $this->ExportXml();
        // $this->_view->loadLayout();
        // $this->_view->renderLayout();
        // $grid = $this->_view->getLayout()->createBlock('Magiccart\Alothemes\Block\Adminhtml\Export\Menu')->toHtml();
        // $this->getResponse()->setBody( $grid );
        $resultPage = $this->_resultPageFactory->create();

 
        return $resultPage;
    }

    public function ExportXml()
    {
        $fileName = 'magicmenu.xml';
        $theme_path = $this->getRequest()->getParam('theme_path');
        $exportIds = $this->getRequest()->getParam('exportIds');
        $dir = $this->_filesystem->getDirectoryWrite(DirectoryList::APP);
        $filePath = sprintf(self::CMS, $theme_path) .$fileName;
        try{
                $collection = $this->_objectManager->create('\Magiccart\Magicmenu\Model\ResourceModel\Magicmenu\Collection');
                $collection->addFieldToFilter('magicmenu_id',array('in'=>$exportIds));
                $options = array('name', 'extra', 'magic_label', 'link', 'ext_content', 'order', 'status');
                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                $xml .= '<root>';
                    $xml.= '<magicmenu>';
                    $num = 0;
                    foreach ($collection as $menu) {
                        $xml.= '<item>';
                        foreach ($options as $opt) {
                            $xml.= '<'.$opt.'><![CDATA['.$menu->getData($opt).']]></'.$opt.'>';
                        }
                        $xml.= '</item>';
                        $num++;
                    }
                    $xml.= '</magicmenu>';
                $xml.= '</root>';
               // $this->_sendUploadResponse($fileName, $xml);
                $dir->writeFile($filePath, '$xml');
                $backupFilePath = $dir->getAbsolutePath($filePath);
                // @mkdir($filePath, 0644, true);
                $doc =  new \DOMDocument('1.0', 'UTF-8');
                $doc->loadXML($xml);
                $doc->formatOutput = true;
                $doc->save($backupFilePath);

                $this->messageManager->addSuccess(__('Export (%1) Item(s):', $num));
                $this->messageManager->addSuccess(__('Successfully exported to file "%1"',$backupFilePath));
        } catch (\Exception $e) {
                $this->messageManager->addError(__('Can not save export file "%1".<br/>"%2"', $filePath, $e->getMessage()));
        }
    }
}
