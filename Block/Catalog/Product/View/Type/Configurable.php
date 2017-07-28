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

use Magento\Catalog\Helper\Product as ProductHelper;
use Magento\Catalog\Model\Product;
use Magento\ConfigurableProduct\Block\Product\View\Type\Configurable as ConfigurableProduct;
use Magento\Catalog\Block\Product\Context;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;

class Configurable extends ConfigurableProduct
{

    /**
     * @var Availability
     */
    private $availability;

    /**
     * Configurable constructor.
     *
     * @param Context                   $context
     * @param ArrayUtils                $arrayUtils
     * @param EncoderInterface          $jsonEncoder
     * @param Data                      $helper
     * @param ProductHelper             $catalogProduct
     * @param CurrentCustomer           $currentCustomer
     * @param PriceCurrencyInterface    $priceCurrency
     * @param ConfigurableAttributeData $configurableAttributeData
     * @param Availability              $availability
     */
    public function __construct(
        Context $context,
        ArrayUtils $arrayUtils,
        EncoderInterface $jsonEncoder,
        Data $helper,
        ProductHelper $catalogProduct,
        CurrentCustomer $currentCustomer,
        PriceCurrencyInterface $priceCurrency,
        ConfigurableAttributeData $configurableAttributeData,
        Availability $availability
    ) {
        $this->availability = $availability;
        $this->jsonEncoder = $jsonEncoder;
        $this->helper = $helper;
        $this->catalogProduct = $catalogProduct;
        parent::__construct(
            $context,
            $arrayUtils,
            $jsonEncoder,
            $helper,
            $catalogProduct,
            $currentCustomer,
            $priceCurrency,
            $configurableAttributeData
        );
    }

    /**
     * @param Product $product
     *
     * @param string  $view
     *
     * @return \Magento\Framework\Phrase
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
}
