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
use Space48\ProductAvailability\Helper\Data;

class ListProduct extends Template
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
     * ListProduct constructor.
     *
     * @param Availability $availability
     * @param Data         $helper
     *
     * @param Context      $context
     * @param array        $data
     */
    public function __construct(
        Availability $availability,
        Data $helper,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->availability = $availability;
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
            $message = __('PRE-ORDER NOW FOR DELIVERY %1 %2', $availability['early_mid_date'], $availability['month']);
        }

        return $message;
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
        return $this->helper->isDebugMode();
    }
}
