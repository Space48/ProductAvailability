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
use Space48\PreSell\Block\PreSell;

class Availability
{

    const PRODUCT_VIEW_PAGE = 'pdp';
    const GROUPED_PRODUCT_PAGE = "grouped";

    /**
     * @var DateTime
     */
    private $dateTime;
    /**
     * @var StockStateInterface
     */
    private $stockState;

    /**
     * @var PreSell
     */
    private $preSell;

    /**
     * Availability constructor.
     *
     * @param DateTime            $dateTime
     * @param StockStateInterface $stockState
     */
    public function __construct(
        DateTime $dateTime,
        StockStateInterface $stockState,
        PreSell $preSell
    ) {
        $this->preSell = $preSell;
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
     * @return string
     */
    public function getAvailabilityDisplay($product, $view)
    {
        $data = [
            'class' => 'unavailable',
            'label' => __("Out of Stock"),
            'has_date' => false
        ];

        /**
         * If the item is set to "Out of Stock" then bypass any other checks. If on the grouped
         * product page we do not display the "Out of Stock" message as this is handled elsewhere
         */

        if (!$this->preSell->getStockItemIsInStock($product->getId())) {
            return $data;
        }

        /**
         * If the item has a positive stock qty it is in stock and no other
         * checks are required
         */
        if ($this->preSell->getStockQty($product) > 0) {
            return [
                'class' => 'available',
                'label' => __("In Stock"),
                'has_date' => false
            ];
        }

        /**
         * If the item is available for pre-sale then display the availability date message
         * if one exists
         */
        if (
            $this->preSell->canPreSell($product) > 0
            && $message = $this->getAvailabilityMessage($product, $view)
        ) {
            $data = [
                'class' => 'unavailable',
                'label' => $message,
                'has_date' => true
            ];
        }

        return $data;
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
        if (!empty($availability = $this->getAvailability($product))) {
            if ($view == self::PRODUCT_VIEW_PAGE || $view == self::GROUPED_PRODUCT_PAGE) {
                $message = __(
                    '<span class="availability-msg">Item due to arrive in stock <em>' . '%1 %2' . '</em></span>',
                    $availability['early_mid_date'],
                    $availability['month']
                );
            } else {
                $message = __(
                    '<span class="availability-msg">Pre-order now for delivery <em>' . '%1 %2' . '</em></span>',
                    $availability['early_mid_date'],
                    $availability['month']
                );
            }
        } else {
            $message = false;
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
