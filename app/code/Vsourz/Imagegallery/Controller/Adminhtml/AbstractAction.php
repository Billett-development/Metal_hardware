<?php

namespace Vsourz\Imagegallery\Controller\Adminhtml;

abstract class AbstractAction extends \Magento\Backend\App\Action
{
    const PARAM_CRUD_ID = 'entity_id';

    protected $_jsHelper;

    protected $_storeManager;

    protected $_resultForwardFactory;

    protected $_resultLayoutFactory;

    protected $_resultPageFactory;

    protected $_categoryFactory;

    protected $_imageFactory;

    //protected $_imageCategoryFactory;

    protected $_categoryCollectionFactory;

    protected $_imageCollectionFactory;

    //protected $_imageCategoryCollectionFactory;

    protected $_coreRegistry;

    protected $_fileFactory;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,

        \Vsourz\Imagegallery\Model\CategoryFactory $categoryFactory,
        \Vsourz\Imagegallery\Model\ImageFactory $imageFactory,
       // \Vsourz\Imagegallery\Model\ImageGalleryFactory $imageCategoryFactory,

        \Vsourz\Imagegallery\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Vsourz\Imagegallery\Model\ResourceModel\Image\CollectionFactory $imageCollectionFactory,
        //\Vsourz\Imagegallery\Model\ResourceModel\ImageGallery\CollectionFactory $imageCategoryCollectionFactory,

        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\View\Result\LayoutFactory $resultLayoutFactory,
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Backend\Helper\Js $jsHelper
    ) {
        parent::__construct($context);

        $this->_coreRegistry = $coreRegistry;
        $this->_fileFactory = $fileFactory;
        $this->_storeManager = $storeManager;
        $this->_jsHelper = $jsHelper;

        $this->_resultPageFactory = $resultPageFactory;
        $this->_resultLayoutFactory = $resultLayoutFactory;
        $this->_resultForwardFactory = $resultForwardFactory;

        $this->_categoryFactory = $categoryFactory;
        $this->_imageFactory = $imageFactory;
        //$this->_imageCategoryFactory = $imageCategoryFactory;

        $this->_categoryCollectionFactory = $categoryCollectionFactory;
        $this->_imageCollectionFactory = $imageCollectionFactory;
        //$this->_imageCategoryCollectionFactory = $imageCategoryCollectionFactory;
        
    }


    protected function _getBackResultRedirect(\Magento\Framework\Controller\Result\Redirect $resultRedirect, $paramCrudId = null)
    {
        switch ($this->getRequest()->getParam('back')) {
            case 'edit':
                $resultRedirect->setPath(
                    '*/*/edit',
                    [
                        static::PARAM_CRUD_ID => $paramCrudId,
                        '_current' => true,
                    ]
                );
                break;
            case 'new':
                $resultRedirect->setPath('*/*/new', ['_current' => true]);
                break;
            default:
                $resultRedirect->setPath('*/*/');
        }

        return $resultRedirect;
    }
}
