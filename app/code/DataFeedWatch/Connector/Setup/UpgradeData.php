<?php
/**
 * Created by Q-Solutions Studio
 * Date: 27.11.2019
 *
 * @category    DataFeedWatch
 * @package     DataFeedWatch_Connector
 * @author      Wojciech M. Wnuk <wojtek@qsolutionsstudio.com>
 */

namespace DataFeedWatch\Connector\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Integration\Model\ConfigBasedIntegrationManager;

class UpgradeData implements UpgradeDataInterface
{
    /**
    * @var ConfigBasedIntegrationManager
    */
    private $integrationManager;

    /**
    * InstallData constructor.
    * @param ConfigBasedIntegrationManager $integrationManager
    */
    public function __construct(ConfigBasedIntegrationManager $integrationManager)
    {
        $this->integrationManager = $integrationManager;
    }

    /**
     * @method upgrade
     * @param  ModuleDataSetupInterface $setup
     * @param  ModuleContextInterface   $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (
            $context->getVersion()
            && version_compare($context->getVersion(), '2.0.3', '<')
            && !(
                version_compare($context->getVersion(), '1.0.2', '==')
                || version_compare($context->getVersion(), '1.0.3', '==')
                )
        ) {
            $setup->getConnection()->delete($setup->getTable('integration'), 'name = \'dfwIntegration\'');
            $this->integrationManager->processIntegrationConfig(['dfwIntegration']);
        }
        $setup->endSetup();
    }
}
