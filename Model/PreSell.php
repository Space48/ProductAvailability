<?php

namespace Space48\ProductAvailability\Model;

use Magento\CatalogInventory\Api\StockItemRepositoryInterface;
use Magento\ProductAlert\Block\Product\View;

class PreSell extends View
{
    private $stockItem;

    public function __construct(
        StockItemRepositoryInterface $stockItem
    ) {
        $this->stockItem = $stockItem;
    }

    /**
     * @param $productId
     * @return float
     */
    public function getStockItemQty($productId)
    {
        $stock = $this->stockItem->get($productId);
        return $stock->getQty();
    }

    /**
     * @param $product
     * @return bool
     */
    public function canPreSell($product)
    {
        if (!$product->getPreSell()) {
            return false;
        }

        return $product->getPreSellQty() > 0 ? true : false;
    }

    /**
     * @param $product
     * @return float
     */
    public function getTotalQty($product)
    {
        $stockQty = $this->getStockQty($product);
        $preSellQty = 0;

        if ($this->canPreSell($product)) {
            $preSellQty = $product->getPreSellQty();
        }

        return $stockQty + $preSellQty;
    }

    /**
     * @param $product
     * @return float
     */
    public function getStockQty($product)
    {
        $productId = $this->getItemId($product);
        return $this->getStockItemQty($productId);
    }

    /**
     * @param $product
     * @return mixed
     */
    public function getItemId($product)
    {
        return $product->getId() ? $product->getId() : $product->getEntityId();
    }

    /**
     * @param $product
     * @return bool
     */
    public function isValidStockProduct($product)
    {
        return $product && $product->getTypeId() == "simple" ? true : false;
    }

    /**
     * If the passed product is not simple, then the item is automatically
     * considered to be in stock and available for presale. Otherwise we
     * find the combined qty and presell qty of the simple product and check
     * if it is above zero.
     *
     * @param $product
     * @return bool
     */
    public function isProductInStockOrAvailableForPreSale($product)
    {
        if (!$this->isValidStockProduct($product)) {
            return true;
        }

        if ($this->getTotalQty($product) > 0) {
            return true;
        }
        return false;
    }

    /**
     * If the passed product is not simple, then the stock level of the item
     * is automatically considered above zero. Otherwise we find the stock
     * level of the simple product and check if it is above zero.
     *
     * @param $product
     * @return bool
     */
    public function isProductStockLevelAboveZero($product)
    {
        if (!$this->isValidStockProduct($product)) {
            return true;
        }

        if ($this->getStockQty($product) > 0) {
            return true;
        }
        return false;
    }

}
