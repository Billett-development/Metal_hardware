<?php

/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Ibnab\MegaMenu\Block\Html;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Theme\Block\Html\Topmenu;
use Magento\Cms\Model\BlockRepository;
use Magento\Catalog\Model\CategoryFactory;
use Magento\Framework\Registry;

/**
 * Html page top menu block
 */
class Topmega extends Topmenu {

    /**
     * Cache identities
     *
     * @var array
     */
    protected $identities = [];

    /**
     * Top menu data tree
     *
     * @var \Magento\Framework\Data\Tree\Node
     */
    protected $_menu;

    /**
     * Core registry
     *
     * @var Registry
     */
    protected $registry;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Cms\Model\Template\FilterProvider
     */
    protected $_filterProvider;

    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Block factory
     *
     * @var \Magento\Cms\Model\BlockFactory
     */
    protected $_blockFactory;

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry = null;

    /**
     * @var \Ibnab\CategoriesUrl\Helper\Data
     */
    protected $dataHelper;

    /**
     * @param Template\Context $context
     * @param NodeFactory $nodeFactory
     * @param TreeFactory $treeFactory
     * @param array $data
     */
    public function __construct(
    Template\Context $context, NodeFactory $nodeFactory, TreeFactory $treeFactory, CategoryFactory $categoryFactory, \Magento\Cms\Model\Template\FilterProvider $filterProvider, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Cms\Model\BlockFactory $blockFactory, Registry $registry, \Ibnab\MegaMenu\Helper\Data $dataHelper, array $data = []
    ) {
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
        $this->categoryFactory = $categoryFactory;
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->_blockFactory = $blockFactory;
        $this->coreRegistry = $registry;
        $this->dataHelper = $dataHelper;
        $this->_menu = $this->getMenu();
    }

    /**
     * Prepare Content HTML
     *
     * @return string
     */
    public function getBlockHtml($id) {
        $blockId = $id;
        $html = '';
        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            /** @var \Magento\Cms\Model\Block $block */
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId);
            if ($block->isActive()) {
                $html = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getContent());
            }
        }
        return $html;
    }

    /**
     * Add sub menu HTML code for current menu item
     *
     * @param \Magento\Framework\Data\Tree\Node $child
     * @param string $childLevel
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string HTML code
     */
    protected function _addSubMenu2($child, $childLevel, $childrenWrapClass, $limit) {

        if ($this->dataHelper->allowExtension()) {
            $html = '';
            if (!$child->hasChildren()) {
                return $html;
            }

            $colStops = null;
            if ($childLevel == 0 && $limit) {
                $colStops = $this->_columnBrake($child->getChildren(), $limit);
            }


            $category = "";
            if ($childLevel == 0) {
                $html .= '<ul>';
                $category = $this->coreRegistry->registry('current_categry_top_level');
                if ($category != null) {
                    if ($category->getUseStaticBlock()) {

                        if ($category->getUseStaticBlockTop() && $category->getStaticBlockTopValue() != "") {
                            $html .= '<div class="topstatic" >';
                            $html .= $this->getBlockHtml($category->getStaticBlockTopValue());
                            $html .= '</div>';
                        }
                        if ($category->getUseStaticBlockLeft() && $category->getStaticBlockLeftValue() != "") {
                            $html .= '<div class="leftstatic" >';
                            $html .= $this->getBlockHtml($category->getStaticBlockLeftValue());
                            $html .= '</div>';
                        }
                    }
                    if ($category->getUseLabel()) {
                        if ($category->getLabelValue() != "") {
                            $child->setData('name', $category->getLabelValue());
                        }
                    }
                }
                if (!$category->getDisabledChildren() && $childLevel == 0) {
                    $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
                }

                if ($category != null) {
                    if ($category->getUseStaticBlock()) {
                        if ($category->getUseStaticBlockRight() && $category->getStaticBlockRightValue() != "") {
                            $html .= '<div class="rightstatic" >';
                            $html .= $this->getBlockHtml($category->getStaticBlockRightValue());
                            $html .= '</div>';
                        }

                        if ($category->getUseStaticBlockBottom() && $category->getStaticBlockBottomValue() != "") {
                            $html .= '<div class="bottomstatic" >';
                            $html .= $this->getBlockHtml($category->getStaticBlockBottomValue());
                            $html .= '</div>';
                        }
                    }
                }
                $html .= '<div class="bottomstatic" ></div>';
                $html .= '</ul>';
            } else {
                $html .= '<ul>';
                $html .= $this->_getHtml($child, $childrenWrapClass, $limit, $colStops);
                $html .= '</ul>';
            }
            return $html;
        } else {
            return parent::_addSubMenu($child, $childLevel, $childrenWrapClass, $limit);
        }
    }

    /**
     * Returns array of menu item's classes
     *
     * @param \Magento\Framework\Data\Tree\Node $item
     * @return array
     */
    protected function _getMenuItemClasses(\Magento\Framework\Data\Tree\Node $item) {

        $classes = [];
        $level = 'level' . $item->getLevel();
        $classes[] = $level;

        $position = $item->getPositionClass();
        $positionArray = explode("-", $position);
        $classes[] = $position;

        if ($item->getIsFirst()) {
            $classes[] = 'first';
        }

        if ($item->getIsActive()) {
            $classes[] = 'active';
        } elseif ($item->getHasActive()) {
            $classes[] = 'has-active';
        }

        if ($item->getIsLast()) {
            $classes[] = 'last';
        }

        if ($item->getClass()) {
            $classes[] = $item->getClass();
        }

        if ($item->hasChildren()) {
            $classes[] = 'parent';
        }

        if ($level == 'level1' && count($positionArray) == 3) {
            $category = $this->coreRegistry->registry('current_categry_top_level');
            if(!is_null($category)){
               $classes[] = $category->getLevelColumnCount();
            }
        }
        return $classes;
    }
    
    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param \Magento\Framework\Data\Tree\Node $menuTree
     * @param string $childrenWrapClass
     * @param int $limit
     * @param array $colBrakes
     * @return string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    
    protected function _getHtml(
    \Magento\Framework\Data\Tree\Node $menuTree, $childrenWrapClass, $limit, $colBrakes = []
    ) {
        $html = '';

        $children = $menuTree->getChildren();
        $parentLevel = $menuTree->getLevel();
        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

        $counter = 1;
        $itemPosition = 1;
        $childrenCount = $children->count();

        $parentPositionClass = $menuTree->getPositionClass();
        $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

        foreach ($children as $child) {
            $child->setLevel($childLevel);
            $child->setIsFirst($counter == 1);
            $child->setIsLast($counter == $childrenCount);
            $child->setPositionClass($itemPositionClassPrefix . $counter);

            $outermostClassCode = '';
            $outermostClass = $menuTree->getOutermostClass();

            if ($childLevel == 0 && $outermostClass) {
                $outermostClassCode = ' class="' . $outermostClass . '" ';
                $child->setClass($outermostClass);
            }
            if(is_array($colBrakes) || is_object($colBrakes)){
            if (count($colBrakes) && $colBrakes[$counter]['colbrake']) {
                $html .= '</ul></li><li class="column"><ul>';
            }
            }
            $html .= '<li ' . $this->_getRenderedMenuItemAttributes($child) . '>';
            if ($child->getCategoryIsLink()) {
                $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '>';
            }else{
                $html .= '<a ' . $outermostClassCode . '>';
            }
            $html .= '<span>' . $this->escapeHtml(
                            $child->getName()
                    ) . '</span>';

                $html .= '</a>';
            

            $html .= $this->_addSubMenu(
                $child,
                $childLevel,
                $childrenWrapClass,
                $limit
            ) . '</li>';;
            $itemPosition++;
            $counter++;
        }
        if(is_array($colBrakes) || is_object($colBrakes)){
        if (count($colBrakes) && $limit) {
            $html = '<li class="column"><ul>' . $html . '</ul></li>';
        }
        }
        return $html;
    }


    /**
     * Recursively generates top menu html from data that is specified in $menuTree
     *
     * @param \Magento\Framework\Data\Tree\Node $menuTree
     * @param string $childrenWrapClass
     * @param int $limit
     * @param array $colBrakes
     * @return string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    protected function _getHtml2(
    \Magento\Framework\Data\Tree\Node $menuTree, $childrenWrapClass, $limit, $colBrakes = []
    ) {
        if ($this->dataHelper->allowExtension()) {
            $html = '';
            $children = $menuTree->getChildren();
            $parentLevel = $menuTree->getLevel();
            $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;

            $counter = 1;
            $itemPosition = 1;
            $childrenCount = $children->count();

            $parentPositionClass = $menuTree->getPositionClass();
            $itemPositionClassPrefix = $parentPositionClass ? $parentPositionClass . '-' : 'nav-';

            foreach ($children as $child) {
                $child->setLevel($childLevel);
                $child->setIsFirst($counter == 1);
                $child->setIsLast($counter == $childrenCount);
                $child->setPositionClass($itemPositionClassPrefix . $counter);

                $outermostClassCode = '';
                $outermostClass = $menuTree->getOutermostClass();

                if ($childLevel == 0 && $outermostClass) {
                    $outermostClassCode = ' class="' . $outermostClass . '" ';
                    $child->setClass($outermostClass);
                }
                if ($childLevel == 0) {
                    $arrayId = explode('-', $child->_getData('id'));
                    $category = null;
                    if (isset($arrayId[2])) {
                        $id = $arrayId[2];
                        $category = $this->categoryFactory->create();
                        $category->load($id);
                        $this->coreRegistry->unregister('current_categry_top_level');
                        $this->coreRegistry->register('current_categry_top_level', $category);
                    }
                }
                if(is_array($colBrakes) || is_object($colBrakes)){
                if (count($colBrakes) && $colBrakes[$counter]['colbrake']) {
                    $html .= '</ul></li><li><ul>';
                }
                }
                $html .= '<li>';

                if ($childLevel == 0) {
                    $name = $child->getName();
                    $category = $this->coreRegistry->registry('current_categry_top_level');
                    if ($category != null) {
                        if ($category->getUseLabel()) {
                            if ($category->getLabelValue() != "") {
                                $name = $category->getLabelValue();
                            } else {
                                $name = $child->getName();
                            }
                        } else {
                            $name = $child->getName();
                        }
                    }
                    if ($category->getCategoryIsLink()) {
                        $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '>';
                    }else{
                        $html .= '<a ' . $outermostClassCode . '>';
                    }
                    $html .= '<span>' . $this->escapeHtml(
                                    $name
                            ) . '</span>';
                        $html .= '</a>';


                    $html .= $this->_addSubMenu2($child, $childLevel, $childrenWrapClass, $limit
                            ) . '</li>';
                } else {
                    $html .= '<a href="' . $child->getUrl() . '" ' . $outermostClassCode . '><span>' . $this->escapeHtml(
                                    $child->getName()
                            ) . '</span></a>' . $this->_addSubMenu2(
                                    $child, $childLevel, $childrenWrapClass, $limit
                            ) . '</li>';
                }
                $itemPosition++;
                $counter++;
            }
            if(is_array($colBrakes) || is_object($colBrakes)){
            if (count($colBrakes) && $limit) {
                $html = '<li class="column"><ul>' . $html . '</ul></li>';
            }
            }
            return $html;
        } else {
            return parent::_getHtml(
                            $menuTree, $childrenWrapClass, $limit, $colBrakes
            );
        }
    }

    /**
     * Get top menu html
     *
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return string
     */
    public function getHtml($outermostClass = '', $childrenWrapClass = '', $limit = 0) {
        if ($childrenWrapClass == "mega") {
            $childrenWrapClass = "submenu";
            $this->_eventManager->dispatch(
                    'page_block_html_topmenu_gethtml_before', ['menu' => $this->_menu, 'block' => $this]
            );

            $this->_menu->setOutermostClass($outermostClass);
            $this->_menu->setChildrenWrapClass($childrenWrapClass);

            $html = $this->_getHtml2($this->_menu, $childrenWrapClass, $limit);

            $transportObject = new \Magento\Framework\DataObject(['html' => $html]);
            $this->_eventManager->dispatch(
                    'page_block_html_topmenu_gethtml_after', ['menu' => $this->_menu, 'transportObject' => $transportObject]
            );
            $html = $transportObject->getHtml();
            return $html;
        } else {
            return parent::getHtml($outermostClass, $childrenWrapClass, $limit);
        }
    }

    public function allowExtension() {
        return $this->dataHelper->allowExtension();
    }

}
