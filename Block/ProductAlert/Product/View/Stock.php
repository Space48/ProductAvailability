<?php

namespace Space48\ProductAvailability\Block\ProductAlert\Product\View;

use Magento\Framework\View\Element\Template\Context;
use Magento\ProductAlert\Block\Product\View;
use Magento\ProductAlert\Helper\Data;
use Space48\ProductAvailability\Model\PreSell;
use Magento\Framework\Registry;
use Magento\Framework\Data\Helper\PostHelper;

class Stock extends View
{
    private $preSell;

    public function __construct(
        Context $context,
        Data $helper,
        Registry $registry,
        PostHelper $coreHelper,
        PreSell $preSell,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $helper,
            $registry,
            $coreHelper,
            $data
        );

        $this->preSell = $preSell;
    }

    public function showNotifyMeButton()
    {
        $product = $this->getProduct();

        if (!$this->_helper->isStockAlertAllowed() ||
            !$this->getProduct() ||
            $this->preSell->isProductStockLevelAboveZero($product)
        ) {
            return false;
        } else {
            $this->setSignupUrl($this->_helper->getSaveUrl('stock'));
            return true;
        }
    }
}
