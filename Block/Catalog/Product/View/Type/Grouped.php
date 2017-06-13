<?php
namespace Space48\ProductAvailability\Block\Catalog\Product\View\Type;

use Space48\ProductAvailability\Model\PreSell;
use Magento\Catalog\Block\Product\View\AbstractView;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;

class Grouped extends AbstractView
{
    private $preSell;
    private $availability;

    public function __construct(
        \Magento\Catalog\Block\Product\Context $context,
        \Magento\Framework\Stdlib\ArrayUtils $arrayUtils,
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
     * @return array
     */
    public function getAssociatedProducts()
    {
        return $this->getProduct()->getTypeInstance()->getAssociatedProducts($this->getProduct());
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

    public function showQtyBoxAfterPreSellCheck($product)
    {
        return $this->preSell->isProductInStockOrAvailableForPreSale($product);
    }

    public function getAvailabilityMessage($product)
    {
        $message = '';
        if (!empty($availability = $this->availability->getAvailability($product))) {
            $message = __('Item due to arrive in stock %1 %2', $availability['early_mid_date'], $availability['month']);
        }

        return $message;
    }
}
