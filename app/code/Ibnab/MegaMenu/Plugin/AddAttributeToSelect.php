<?php
namespace Ibnab\MegaMenu\Plugin;
use Magento\Catalog\Plugin\Block\Topmenu;
use Magento\Framework\Data\Tree\Node;
class AddAttributeToSelect extends Topmenu
{
    /**
     * Catalog category
     *
     * @var \Magento\Catalog\Helper\Category
     */
    protected $catalogCategory;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var \Magento\Catalog\Model\Layer\Resolver
     */
    private $layerResolver;
    /**
     * @var \Ibnab\CategoriesUrl\Helper\Data
     */
    protected $dataHelper;


    public function __construct(
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\ResourceModel\Category\StateDependentCollectionFactory $categoryCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \Ibnab\MegaMenu\Helper\Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->catalogCategory = $catalogCategory;
        $this->collectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
        $this->layerResolver = $layerResolver;
        parent::__construct($catalogCategory,$categoryCollectionFactory,$storeManager,$layerResolver);
    }

    public function beforeLoad($collection,$printQuery = false, $logQuery = false)
    {
        if($this->dataHelper->allowExtension())
        {
        $collection->addAttributeToSelect('category_is_link');
        }
    }

    private function getCategoryAsArray($category, $currentCategory)
    {
       
        return [
            'name' => $category->getName(),
            'id' => 'category-node-' . $category->getId(),
            'url' => $this->catalogCategory->getCategoryUrl($category),
            'has_active' => in_array((string)$category->getId(), explode('/', $currentCategory->getPath()), true),
            'is_active' => $category->getId() == $currentCategory->getId(),
            'category_is_link' => $category->getCategoryIsLink()
        ];
    }
    /**
     * Get current Category from catalog layer
     *
     * @return \Magento\Catalog\Model\Category
     */
    private function getCurrentCategory()
    {
        $catalogLayer = $this->layerResolver->get();

        if (!$catalogLayer) {
            return null;
        }

        return $catalogLayer->getCurrentCategory();
    }
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $rootId = $this->storeManager->getStore()->getRootCategoryId();
        $storeId = $this->storeManager->getStore()->getId();
        
        /** @var \Magento\Catalog\Model\ResourceModel\Category\Collection $collection */
        $collection = $this->getCategoryTree($storeId, $rootId);
        
        $currentCategory = $this->getCurrentCategory();
        $mapping = [$rootId => $subject->getMenu()];  // use nodes stack to avoid recursion
        
        foreach ($collection as $category) {
            
            $categoryParentId = $category->getParentId();
            if (!isset($mapping[$categoryParentId])) {
                $parentIds = $category->getParentIds();
                foreach ($parentIds as $parentId) {
                    if (isset($mapping[$parentId])) {
                        $categoryParentId = $parentId;
                    }
                }
            }
            
            /** @var Node $parentCategoryNode */
            $parentCategoryNode = $mapping[$categoryParentId];
            $categoryNode = new Node(
                $this->getCategoryAsArray($category, $currentCategory),
                'id',
                $parentCategoryNode->getTree(),
                $parentCategoryNode
            );
            
            $parentCategoryNode->addChild($categoryNode);

            $mapping[$category->getId()] = $categoryNode; //add node in stack
        }
    }
}
