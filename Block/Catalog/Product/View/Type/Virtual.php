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
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Catalog\Block\Product\View\Type\Virtual as VirtualProduct;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;

class Virtual extends VirtualProduct
{

    /**
     * @var Availability
     */
    private $availability;

    /**
     * Simple constructor.
     *
     * @param Context      $context
     * @param ArrayUtils   $arrayUtils
     * @param Availability $availability
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        Availability $availability
    ) {
        $this->availability = $availability;
        parent::__construct($context, $arrayUtils);
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
}
