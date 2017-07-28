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
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\ArrayUtils;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;

class Simple extends SimpleProduct
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
     *
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
     * @param        $product
     *
     * @param string $view
     *
     * @return array
     */
    public function getAvailability($product, $view = 'pdp')
    {
        return $this->availability->getAvailabilityDisplay($product, $view);
    }

    /**
     * @param $product
     *
     * @return bool
     */
    public function isInStock($product)
    {
        return $this->availability->getAvailableStock($product) ? true : false;
    }

    public function isDebugMode()
    {
        return false;
    }
}
