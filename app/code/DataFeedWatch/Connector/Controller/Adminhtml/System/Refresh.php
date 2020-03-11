<?php
/**
 * Created by Q-Solutions Studio
 * Date: 01.07.19
 *
 * @category    DataFeedWatch
 * @package     DataFeedWatch_Connector
 * @author      Maciej Buchert <maciej@qsolutionsstudio.com>
 */

namespace DataFeedWatch\Connector\Controller\Adminhtml\System;

use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Refresh
 * @package DataFeedWatch\Connector\Controller\Adminhtml\System
 */
class Refresh extends Button
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            $this->curl->setOption(CURLOPT_HTTPGET, true);
            $this->curl->setOption(CURLOPT_RETURNTRANSFER, true);
            $this->curl->setOption(CURLOPT_FOLLOWLOCATION, true);
            $this->curl->setOption(CURLOPT_HEADER, true);
            $this->curl->get($this->dataHelper->getRegisterUrl());

            $this->getMessageManager()->addSuccessMessage(__('DataFeedWatch integration access has been refreshed'));

            return $this->getResponse()->setRedirect($this->_redirect->getRefererUrl());
        } catch (Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());

            return $this->getResponse()->setRedirect($this->_redirect->getRefererUrl());
        }
    }
}
