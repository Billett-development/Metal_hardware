<?php
/**
 * Created by Q-Solutions Studio
 * Date: 01.07.19
 *
 * @category    DataFeedWatch
 * @package     DataFeedWatch_Connector
 * @author      Maciej Buchert <maciej@qsolutionsstudio.com>
 */

namespace DataFeedWatch\Connector\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Integration\Model\Integration;
use Magento\Integration\Model\IntegrationService;
use Magento\Integration\Api\OauthServiceInterface as OauthService;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class Data
 * @package DataFeedWatch\Connector\Helper
 */
class Data extends AbstractHelper
{
    const MY_DATA_FEED_WATCH_URL = 'https://app.datafeedwatch.com/';
    const VERSION_PARAMETER_XML_PATH = "dfw_connector/general/version";

    /**
     * @var IntegrationService
     */
    protected $integrationService;
    /**
     * @var OauthService
     */
    protected $oauthService;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @method __construct
     * @param  Context               $context
     * @param  IntegrationService    $integrationService
     * @param  OauthService          $oauthService
     * @param  StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        IntegrationService $integrationService,
        OauthService $oauthService,
        StoreManagerInterface $storeManager
        )
    {
        parent::__construct($context);

        $this->integrationService = $integrationService;
        $this->oauthService = $oauthService;
        $this->storeManager = $storeManager;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getConfig($path)
    {
        return $this->scopeConfig->getValue($path);
    }

    /**
     * @method getAccessToken
     * @return string
     */
    public function getAccessToken()
    {
        $integration = $this->integrationService->findByName('dfwIntegration');

        if ($integration->getStatus() == Integration::STATUS_INACTIVE) {
            if ($integration->getConsumerId()) {
                $integration->setStatus(Integration::STATUS_ACTIVE);
                $this->integrationService->update($integration->getData());
                $this->oauthService->createAccessToken($integration->getConsumerId(), true);
            }
        }

        if ($integration->getConsumerId()) {
            return $this->oauthService->getAccessToken($integration->getConsumerId())->getToken();
        }


        return '';
    }

    /**
     * @method getRegisterUrl
     * @return string
     */
    public function getRegisterUrl()
    {
        $registerUrl = sprintf('%splatforms/magento/sessions/finalize', self::MY_DATA_FEED_WATCH_URL);

        return $registerUrl . '?shop=' . $this->storeManager->getStore()->getBaseUrl() . '&token='
            . $this->getAccessToken() . '&version=' . $this->getConfig(Data::VERSION_PARAMETER_XML_PATH);
    }
}
