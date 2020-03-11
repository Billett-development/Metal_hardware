<?php
/**
 * @author      WebPanda
 * @package     WebPanda_AutoInvoice
 * @copyright   Copyright (c) WebPanda (https://webpanda-solutions.com/)
 * @license     https://webpanda-solutions.com/license-agreement
 */

namespace WebPanda\AutoInvoice\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Sales\Model\Service\InvoiceService;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Event\Observer;
use Magento\Sales\Model\ResourceModel\Order\Invoice\CollectionFactory as InvoiceCollectionFactory;
use Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader;
use Magento\Sales\Model\Order\Shipment\ShipmentValidatorInterface;
use Magento\Sales\Model\Order\Shipment\Validation\QuantityValidator;
use Magento\Sales\Model\Order\Email\Sender\ShipmentSender;
use WebPanda\AutoInvoice\Helper\Data as ConfigHelper;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Framework\Registry as CoreRegistry;

/**
 * Class SalesOrderSaveAfter
 * @package WebPanda\AutoInvoice\Observer
 */
class SalesOrderSaveAfter implements ObserverInterface
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @var InvoiceService
     */
    protected $invoiceService;

    /**
     * @var TransactionFactory
     */
    protected $transactionFactory;

    /**
     * @var InvoiceCollectionFactory
     */
    protected $invoiceCollectionFactory;

    /**
     * @var ShipmentValidatorInterface
     */
    private $shipmentValidator;

    /**
     * @var ShipmentSender
     */
    protected $shipmentSender;

    /**
     * @var InvoiceSender
     */
    protected $invoiceSender;

    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var CoreRegistry
     */
    protected $coreRegistry;

    /**
     * SalesOrderSaveAfter constructor.
     * @param ObjectManagerInterface $objectManager
     * @param InvoiceService $invoiceService
     * @param TransactionFactory $transactionFactory
     * @param InvoiceCollectionFactory $invoiceCollectionFactory
     * @param ShipmentValidatorInterface $shipmentValidator
     * @param ShipmentSender $shipmentSender
     * @param InvoiceSender $invoiceSender
     * @param ConfigHelper $configHelper
     * @param CoreRegistry $coreRegistry
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        InvoiceService $invoiceService,
        TransactionFactory $transactionFactory,
        InvoiceCollectionFactory $invoiceCollectionFactory,
        ShipmentValidatorInterface $shipmentValidator,
        ShipmentSender $shipmentSender,
        InvoiceSender $invoiceSender,
        ConfigHelper $configHelper,
        CoreRegistry $coreRegistry
    ) {
        $this->objectManager = $objectManager;
        $this->invoiceService = $invoiceService;
        $this->transactionFactory = $transactionFactory;
        $this->invoiceCollectionFactory = $invoiceCollectionFactory;
        $this->shipmentValidator = $shipmentValidator;
        $this->shipmentSender = $shipmentSender;
        $this->invoiceSender = $invoiceSender;
        $this->configHelper = $configHelper;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @param Observer $observer
     * @return null
     */
    public function execute(Observer $observer)
    {
        if ($observer->getOrders()) {
            foreach ($observer->getOrders() as $order) {
                if ($this->configHelper->getOrderTotalThreshold() == 'zero_total' && $order->getGrandTotal() > 0) {
                    return false;
                }
                $this->createInvoice($order);
                $this->createShipment($order);
            }
        } else {
            $order = $observer->getEvent()->getOrder();
            if ($this->configHelper->getOrderTotalThreshold() == 'zero_total' && $order->getGrandTotal() > 0) {
                return false;
            }
            $this->createInvoice($order);
            $this->createShipment($order);
        }

        return $this;
    }

    /**
     * @param $order
     * @return bool|\Magento\Sales\Model\Order\Invoice
     */
    protected function createInvoice($order)
    {
        if(!$this->configHelper->isEnabledInvoice() || !$order->canInvoice() || !$order->getState() == 'new') {
            return false;
        }

        // make sure to check if another extension already created any invoice
        $invoices = $this->invoiceCollectionFactory->create()
            ->addAttributeToFilter('order_id', array('eq' => $order->getId()));
        $invoices->getSelect()->limit(1);
        if ((int)$invoices->count() !== 0) {
            return false;
        }

        try {
            $invoice = $this->invoiceService->prepareInvoice($order);
            $invoice->setRequestedCaptureCase(\Magento\Sales\Model\Order\Invoice::CAPTURE_ONLINE);
            $invoice->register();
            $invoice->getOrder()->setIsInProcess(true);
            if ($this->configHelper->isEnabledSendInvoiceMail()) {
                $invoice->getOrder()->setCustomerNoteNotify(true);
            } else {
                $invoice->getOrder()->setCustomerNoteNotify(false);
            }

            $transaction = $this->transactionFactory->create()
                ->addObject($invoice)
                ->addObject($invoice->getOrder());
            $transaction->save();

            if ($this->configHelper->isEnabledSendInvoiceMail()) {
                $this->invoiceSender->send($invoice);
            }

            // make sure to remove the registry for multiple addresses checkout
            $this->coreRegistry->unregister('current_invoice');
        } catch (\Exception $e) {
            $order->addStatusHistoryComment('Exception message: '.$e->getMessage(), false);
            $order->save();
            return false;
        }

        return $invoice;
    }

    /**
     * @param $order
     * @return bool|\Magento\Sales\Model\Order\Shipment
     */
    protected function createShipment($order)
    {
        if (!$this->configHelper->isEnabledShipment() || !$order->canShip()) {
            return false;
        }

        $data = [];
        foreach ($order->getAllVisibleItems() as $item) {
            $data[$item->getId()] = $item->getQty();
        }
        try {
            $shipmentLoader = $this->objectManager->create(
                \Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader::class
            );
            $shipmentLoader->setOrderId($order->getId());
            $shipmentLoader->setShipment($data);
            $shipment = $shipmentLoader->load();
            if (!$shipment) {
                return false;
            }
            $validationResult = $this->shipmentValidator
                ->validate($shipment, [QuantityValidator::class]);

            if ($validationResult->hasMessages()) {
                throw new \Exception(__("Shipment Document Validation Error(s):\n" . implode("\n", $validationResult->getMessages())));
            }

            $shipment->register();
            if ($this->configHelper->isEnabledSendShipmentMail()) {
                $shipment->getOrder()->setCustomerNoteNotify(true);
            } else {
                $shipment->getOrder()->setCustomerNoteNotify(false);
            }

            $this->saveShipment($shipment);
            if ($this->configHelper->isEnabledSendShipmentMail()) {
                $this->shipmentSender->send($shipment);
            }

            // make sure to remove the registry for multiple addresses checkout
            $this->coreRegistry->unregister('current_shipment');
        } catch (\Exception $e) {
            $order->addStatusHistoryComment('Exception message: '.$e->getMessage(), false);
            $order->save();
            return false;
        }

        return $shipment;
    }

    /**
     * Save shipment and order in one transaction
     *
     * @param \Magento\Sales\Model\Order\Shipment $shipment
     * @return $this
     */
    protected function saveShipment($shipment)
    {
        $shipment->getOrder()->setIsInProcess(true);
        $transaction = $this->transactionFactory->create();
        $transaction->addObject(
            $shipment
        )->addObject(
            $shipment->getOrder()
        )->save();

        return $this;
    }
}
