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

use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Space48\ProductAvailability\Helper\Config;
use Space48\PreSell\Block\PreSell;

class ListProductTest extends \PHPUnit_Framework_TestCase
{

    public function testBlockIsInstanceOfTemplate()
    {
        $block = $this->getBlock();
        $this->assertInstanceOf(Template::class, $block);
    }

    /**
     * @return ListProduct
     * @internal param $stubAvailability
     * @internal param $stubHelper
     * @internal param $stubContext
     *
     */
    private function getBlock()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject | StockStateInterface $stockStateInterfaceMock */
        $stockStateInterfaceMock = $this->getMockBuilder(StockStateInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | Context $preSellMock */
        $preSellMock = $this->getMockBuilder(PreSell::class)
            ->disableOriginalConstructor()
            ->getMock();

        $availability = new Availability(new DateTime(), $stockStateInterfaceMock, $preSellMock);

        /** @var \PHPUnit_Framework_MockObject_MockObject | Config $stubConfig */
        $stubConfig = $this->getMockBuilder(Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | Context $stubContext */
        $stubContext = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();



        $block = new ListProduct($availability, $stubConfig, $stubContext);

        return $block;
    }

    public function testAvailabilityReturnsInstanceIf()
    {
        $product = $this->getProduct();
        $availability = $this->getBlock()->getAvailability($product);

        $this->assertInstanceOf(Phrase::class, $availability['label']);
    }

    /**
     * @return Product | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getProduct()
    {
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product->method('getData')->with('available_from_x')->willReturn('2017-05-31 00:00:00');

        return $product;
    }
}
