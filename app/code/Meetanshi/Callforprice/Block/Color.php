<?php
/**
 * Provider: Meetanshi.
 * Package: Meetanshi Recent Sales Notification
 * Support: support@meetanshi.com (https://meetanshi.com/)
 */

namespace Meetanshi\Callforprice\Block;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Magento\Framework\Registry;

class Color extends Field
{
    protected $coreRegistry;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        array $data = []
    )
    {
        $this->coreRegistry = $coreRegistry;
        parent::__construct($context, $data);
    }

    protected function _getElementHtml(AbstractElement $element)
    {
        $html = $element->getElementHtml();
        $cpPath = $this->getViewFileUrl('Meetanshi_Callforprice::js');
        if (!$this->coreRegistry->registry('colorpicker_loaded')) {
            $html .= '<script type="text/javascript" src="' . $cpPath . '/' . 'jscolor.js"></script>';
            $this->coreRegistry->registry('colorpicker_loaded', 1);
        }
        $html .= '<script type="text/javascript">
                var el = document.getElementById("' . $element->getHtmlId() . '");
                el.className = el.className + " jscolor{hash:true}";
            </script>';

        return $html;
    }

}