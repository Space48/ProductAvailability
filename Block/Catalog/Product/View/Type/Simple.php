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
     * Simple constructor.
     *
     * @param Context      $context
     * @param ArrayUtils   $arrayUtils
     * @param Availability $availability
     * @param Data         $helper
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        Availability $availability,
        Data $helper
    )
    {
        $this->availability = $availability;
        parent::__construct($context, $arrayUtils);
        $this->helper = $helper;
    }

    /**
     * @param $product
     *
     * @return \Magento\Framework\Phrase
     */
    public function getAvailability($product)
    {
        $message = '';
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
}