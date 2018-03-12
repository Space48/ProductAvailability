<?php
/**
 * SimpleTest.php
 *
 * @Date        07/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

namespace Space48\ProductAvailability\Block\Catalog\Product\View\Type;

use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Framework\Stdlib\DateTime;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;
use Space48\PreSell\Block\PreSell;

class SimpleTest extends \PHPUnit_Framework_TestCase
{

    /** @var  Product */
    public $product;

    public function setUp()
    {
        $this->product = $this->getProduct();
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
        $product->method('getId')->willReturn(1);
        $product->method('getWebsiteId')->willReturn(1);

        return $product;
    }

    public function testGetAvailabilityForPdpProduct()
    {
        $availability = $this->getBlock()->getAvailability($this->product, 'pdp');
        $expected = __('Item due to arrive in stock <em>%1 %2</em>', ['late', 'May']);
        $PdpAvailabilityMessage = $availability['label'];

        $this->assertEquals($expected, $PdpAvailabilityMessage);

    }

    /**
     * @return Simple
     */
    public function getBlock()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject | Context $contextMock */
        $contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | ArrayUtils $arrayUtilsMock */
        $arrayUtilsMock = $this->getMockBuilder(ArrayUtils::class)->disableOriginalConstructor()->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | StockStateInterface $stockStateInterfaceMock */
        $stockStateInterfaceMock = $this->getMockBuilder(StockStateInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | PreSell $preSellMock */
        $preSellMock = $this->getMockBuilder(PreSell::class)
            ->disableOriginalConstructor()
            ->getMock();

        $preSellMock->method('getStockItemIsInStock')->willReturn(true);
        $preSellMock->method('getStockQty')->willReturn(0);
        $preSellMock->method('canPreSell')->willReturn(true);

        $availability = new Availability(new DateTime(), $stockStateInterfaceMock, $preSellMock);

        return new Simple(
            $contextMock,
            $arrayUtilsMock,
            $availability
        );
    }

    public function testGetAvailabilityForPlpProduct()
    {
        $availability = $this->getBlock()->getAvailability($this->product, 'plp');
        $expected = __('PRE-ORDER NOW FOR DELIVERY <em>%1 %2</em>', ['late', 'May']);
        $PdpAvailabilityMessage = $availability['label'];

        $this->assertEquals($expected, $PdpAvailabilityMessage);
    }

    public function testIsInStockReturnsRightType()
    {
        $this->assertInternalType('bool', $this->getBlock()->isInStock($this->product));
    }
}
