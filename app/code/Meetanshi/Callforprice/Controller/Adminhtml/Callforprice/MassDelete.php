<?php

namespace Meetanshi\Callforprice\Controller\Adminhtml\Callforprice;

use Magento\Backend\App\Action;
use Magento\Ui\Component\MassAction\Filter;
use Meetanshi\Callforprice\Model\ResourceModel\Callforprice\CollectionFactory;
use Meetanshi\Callforprice\Model\Callforprice;

class MassDelete extends Action
{
    protected $callforprice;
    protected $messageManager;
    protected $filter;
    protected $collectionFactory;

    public function __construct(
        Callforprice $callforprice,
        Action\Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->callforprice = $callforprice;
        parent::__construct($context);
    }

    public function execute()
    {
        try{
            $collection = $this->filter->getCollection($this->collectionFactory->create());
            $collectionSize = $collection->getSize();

            foreach ($collection as $item) {
                $id = $item['id'];
                $row = $this->callforprice->load($id);
                $row->delete();
            }
            $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        }catch (\Exception $e){
            $this->messageManager->addError($e->getMessage());
        }
        $this->_redirect('*/callforprice/index');
    }
}
