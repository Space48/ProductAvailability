<?php

namespace Space48\ProductAvailability\Block\Catalog\Product;

use Magento\Catalog\Block\Product\View as ProductView;
use Space48\ProductAvailability\Model\PreSell;
use Magento\Catalog\Api\ProductRepositoryInterface;

class View extends ProductView
{
    private $preSell;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        PreSell $preSell,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );

        $this->preSell = $preSell;
    }

    public function showAddToCartButtonAfterPreSellCheck()
    {
        return $this->preSell->isProductInStockOrAvailableForPreSale($this->getProduct());
    }
}
