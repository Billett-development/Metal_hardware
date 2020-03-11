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
use Magento\Framework\HTTP\Client\Curl;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;

/**
 * Class Button
 * @package DataFeedWatch\Connector\Controller\Adminhtml\System
 */
abstract class Button extends Action
{
    const ADMIN_RESOURCE = 'DataFeedWatch_Connector::config';

    /**
     * @var Data
     */
    public $dataHelper;
    /**
     * @var Curl
     */
    protected $curl;

    /**
     * Button constructor.
     * @param Context $context
     * @param Data $dataHelper
     * @param User $apiUser
     */
    public function __construct(
        Context $context,
        Data $dataHelper,
        Curl $curl
    ) {
        $this->dataHelper     = $dataHelper;
        $this->curl           = $curl;
        parent::__construct($context);
    }
}
