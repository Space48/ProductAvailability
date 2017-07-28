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

namespace Space48\ProductAvailability\Block\Catalog\Product;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Space48\ProductAvailability\Helper\Config;

class ListProduct extends Template
{

    const PRODUCT_LIST_PAGE = 'plp';

    /**
     * @var Availability
     */
    private $availability;
    /**
     * @var Config
     */
    private $config;

    /**
     * ListProduct constructor.
     *
     * @param Availability $availability
     * @param Config       $config
     *
     * @param Context      $context
     * @param array        $data
     */
    public function __construct(
        Availability $availability,
        Config $config,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->availability = $availability;
        $this->config = $config;
    }

    /**
     * @param $product
     *
     * @return \Magento\Framework\Phrase
     */
    public function getAvailability($product)
    {
        return $this->availability->getAvailabilityDisplay($product, self::PRODUCT_LIST_PAGE);
    }

    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->getData('product');
    }

    /**
     * @return bool
     */
    public function isDebugMode()
    {
        return $this->config->isDebugMode();
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
