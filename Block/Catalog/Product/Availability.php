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

namespace Space48\ProductAvailability\Block\Catalog\Product;

use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime;

class Availability
{

    const PRODUCT_VIEW_PAGE = 'pdp';

    /**
     * @var DateTime
     */
    private $dateTime;
    /**
     * @var StockStateInterface
     */
    private $stockState;

    /**
     * Availability constructor.
     *
     * @param DateTime            $dateTime
     * @param StockStateInterface $stockState
     */
    public function __construct(
        DateTime $dateTime,
        StockStateInterface $stockState
    ) {
        $this->dateTime = $dateTime;
        $this->stockState = $stockState;
    }

    /**
     * @param $product Product
     *
     * @return float
     */
    public function getAvailableStock($product)
    {
        return $this->stockState->getStockQty($product->getId());
    }

    /**
     * @param $product Product
     *
     * @param $view    string
     *
     * @return Phrase
     */
    public function getAvailabilityMessage($product, $view = 'pdp')
    {
        $message = __('');
        if (!empty($availability = $this->getAvailability($product))) {
            if ($view == self::PRODUCT_VIEW_PAGE) {
                $message = __('Item due to arrive in stock %1 %2', $availability['early_mid_date'], $availability['month']);
            } else {
                $message = __('PRE-ORDER NOW FOR DELIVERY %1 %2', $availability['early_mid_date'], $availability['month']);
            }
        }

        return $message;
    }

    /**
     * @param $product
     *
     * @return array
     */
    private function getAvailability($product): array
    {
        $availableFromDate = [];
        /** @var $product Product */
        if (!empty($availableFromX = $this->dateTime->strToTime($product->getData('available_from_x')))) {
            $availableFromDate['day'] = date('d', $availableFromX);
            $availableFromDate['month'] = date('F', $availableFromX);
            $availableFromDate['early_mid_date'] = $this->getEarlyMidLate($availableFromDate['day']);
        }

        return $availableFromDate;
    }

    /**
     * @param $day
     *
     * @return string
     */
    private function getEarlyMidLate($day): string
    {
        $day = (int) $day;

        return ($day <= 10 ? 'early' : ($day <= 20 ? 'mid' : 'late'));
    }
}
