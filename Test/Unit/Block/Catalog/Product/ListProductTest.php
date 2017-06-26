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

use Magento\Catalog\Model\Product;

use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Space48\ProductAvailability\Helper\Data;

class ListProductTest extends \PHPUnit_Framework_TestCase
{

    public function testBlockIsInstanceOfTemplate()
    {

        $block = $this->getBlock();
        $this->assertInstanceOf(Template::class, $block);
    }

    /**
     * @param $stubAvailability
     * @param $stubHelper
     * @param $stubContext
     *
     * @return \Space48\ProductAvailability\Block\Catalog\Product\ListProduct
     */
    private function getBlock(): ListProduct
    {
        $stubAvailability = new Availability(new DateTime());

        $stubHelper = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        $stubContext = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $block = new ListProduct($stubAvailability, $stubHelper, $stubContext);

        return $block;
    }

    public function testAvailabilityReturnsInstanceIf()
    {
        $product = $this->getProduct();

        $this->assertInstanceOf(Phrase::class, $this->getBlock()->getAvailability($product));

        $this->assertContains(
            'PRE-ORDER NOW FOR DELIVERY %1 %2',
            $this->getBlock()->getAvailability($product)->getText()
        );
    }

    /**
     * @return Product | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getProduct(): \PHPUnit_Framework_MockObject_MockObject
    {
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product->method('getData')->with('available_from_x')->willReturn('2017-05-31 00:00:00');

        return $product;
    }
}
