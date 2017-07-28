<?php

namespace Space48\ProductAvailability\Block\Catalog\Product\View\Type;

use Magento\Catalog\Block\Product\Context;
use Magento\Framework\Stdlib\ArrayUtils;
use Space48\PreSell\Block\PreSell;
use Magento\Catalog\Block\Product\View\AbstractView;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;

class Grouped extends AbstractView
{

    private $preSell;
    private $availability;

    /**
     * Grouped constructor.
     *
     * @param Context      $context
     * @param ArrayUtils   $arrayUtils
     * @param PreSell      $preSell
     * @param Availability $availability
     * @param array        $data
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        PreSell $preSell,
        Availability $availability,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $arrayUtils,
            $data
        );

        $this->preSell = $preSell;
        $this->availability = $availability;
    }

    /**
     * Set preconfigured values to grouped associated products
     *
     * @return $this
     */
    public function setPreconfiguredValue()
    {
        $configValues = $this->getProduct()->getPreconfiguredValues()->getSuperGroup();
        if (is_array($configValues)) {
            $associatedProducts = $this->getAssociatedProducts();
            foreach ($associatedProducts as $item) {
                if (isset($configValues[$item->getId()])) {
                    $item->setQty($configValues[$item->getId()]);
                }
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getAssociatedProducts()
    {
        return $this->getProduct()->getTypeInstance()->getAssociatedProducts($this->getProduct());
    }

    public function showQtyBoxAfterPreSellCheck($product)
    {
        return $this->preSell->isProductInStockOrAvailableForPreSale($product);
    }

    public function getAvailability($product)
    {
        return $this->availability->getAvailabilityDisplay($product, "grouped");
    }
}
