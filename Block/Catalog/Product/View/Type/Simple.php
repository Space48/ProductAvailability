<?php
/**
 * Space48_ProductAvailability
 *
 * @category    Space48
 * @package     Space48_ProductAvailability
 * @Date        03/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

declare(strict_types=1);

namespace Space48\ProductAvailability\Block\Catalog\Product\View\Type;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Block\Product\View\Type\Simple as SimpleProduct;
use Magento\Framework\Stdlib\ArrayUtils;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;
use Space48\ProductAvailability\Helper\Data;
use Magento\CatalogInventory\Api\StockStateInterface;

class Simple extends SimpleProduct
{

    /**
     * @var Availability
     */
    private $availability;
    /**
     * @var Data
     */
    private $helper;

    /**
     * @var StockStateInterface
     */
    private $stockStateInterface;

    /**
     * Simple constructor.
     *
     * @param Context               $context
     * @param ArrayUtils            $arrayUtils
     * @param Availability          $availability
     * @param StockStateInterface   $stockStateInterface
     * @param Data                  $helper
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        Availability $availability,
        StockStateInterface $stockStateInterface,
        Data $helper
    ) {
        $this->availability = $availability;
        $this->helper = $helper;
        $this->stockStateInterface = $stockStateInterface;
        parent::__construct($context, $arrayUtils);
    }

    /**
     * @param $product
     *
     * @return \Magento\Framework\Phrase
     */
    public function getAvailability($product)
    {
        $message = __('');
        if (!empty($availability = $this->availability->getAvailability($product))) {
            $message = __('Item due to arrive in stock %1 %2', $availability['early_mid_date'], $availability['month']);
        }

        return $message;
    }

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->helper->isDebugMode();
    }

    public function getProductStockQty($product)
    {
        return $this->stockStateInterface->getStockQty(
            $product->getId(),
            $product->getStore()->getWebsiteId()
        );
    }
}
