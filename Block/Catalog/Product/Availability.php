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

use Magento\Framework\Stdlib\DateTime;

class Availability
{

    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * Availability constructor.
     *
     * @param DateTime $dateTime
     *
     */
    public function __construct(
        DateTime $dateTime
    )
    {
        $this->dateTime = $dateTime;
    }

    /**
     * @param $product
     *
     * @return array
     */
    public function getAvailability($product): array
    {
        $availableFromDate = array();
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
        $day = intval($day);

        return ($day <= 10 ? 'early' : ($day <= 20 ? 'mid' : 'late'));
    }

}


