<?php

namespace Meetanshi\Callforprice\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Model\Product;

class ProductName extends Column
{
    private $product;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Product $product,
        array $components = [],
        array $data = [],
        $storeKey = 'store_view'
    )
    {
        $this->product = $product;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $productId = $item['productid'];
                if (!$productId) {
                    $item['productid'] = __('');
                } else {
                    $product = $this->product->load($productId);
                    $item['productid'] = __($product->getName() . '<br>');
                }
            }
        }
        return $dataSource;
    }
}