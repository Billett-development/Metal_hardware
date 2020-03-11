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

use DataFeedWatch\Connector\Helper\Data;
use Exception;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Open
 * @package DataFeedWatch\Connector\Controller\Adminhtml\System
 */
class Open extends Button
{
    /**
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        try {
            return $this->getResponse()->setRedirect($this->dataHelper->getRegisterUrl());
        } catch (Exception $e) {
            $this->getMessageManager()->addErrorMessage($e->getMessage());

            return $this->getResponse()->setRedirect($this->_redirect->getRefererUrl());
        }
    }
}
