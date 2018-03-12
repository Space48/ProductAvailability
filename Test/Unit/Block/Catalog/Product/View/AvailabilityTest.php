<?php
/**
 * Space48_ProductAvailability
 *
 * @category    Space48
 * @package     Space48_ProductAvailability
 * @Date        03/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @adampmoss
 */

namespace Space48\ProductAvailability\Block\Catalog\Product;

use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Stdlib\DateTime;
use Space48\PreSell\Block\PreSell;
use Magento\Framework\Phrase;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;

class AvailabilityTest extends \PHPUnit_Framework_TestCase
{
    private $availability;
    private $preSellMock;

    public function setUp()
    {
        $stockStateInterfaceMock = $this->getMockBuilder(StockStateInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->preSellMock = $this->getMockBuilder(PreSell::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->availability = new Availability(new DateTime(), $stockStateInterfaceMock, $this->preSellMock);
    }

    /**
     * @return Product | \PHPUnit_Framework_MockObject_MockObject
     */
    private function getProductMock()
    {
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product->method('getId')->willReturn(1);

        return $product;
    }

    /**
     * @param $isInStock
     * @param $type
     * @param $qty
     * @param $canPreSell
     * @param $availabilityDate
     * @param $expected
     *
     * @dataProvider availabilityProvider
     */
    public function testAvailabilityDisplayReturnsExpectedOutcome(
        $isInStock,
        $type,
        $qty,
        $canPreSell,
        $availabilityDate,
        $expected
    ) {
        $productMock = $this->getProductMock();
        $productMock->method('getData')->with('available_from_x')->willReturn($availabilityDate);

        $this->preSellMock->method('getStockItemIsInStock')->willReturn($isInStock);
        $this->preSellMock->method('getStockQty')->willReturn($qty);
        $this->preSellMock->method('canPreSell')->willReturn($canPreSell);
        $result = $this->availability->getAvailabilityDisplay($productMock, $type);

        $this->assertEquals($expected, $result);
    }

    public function availabilityProvider()
    {
        return [
            [false, "pdp", null, null, null, [
                'class' => 'unavailable',
                'label' => __("Out of Stock"),
                'has_date' => false
            ]],
            [true, "pdp", 3, null, null, [
                'class' => 'available',
                'label' => __("In Stock"),
                'has_date' => false
            ]],
            [true, "pdp", 0, false, null, [
                'class' => 'unavailable',
                'label' => __("Out of Stock"),
                'has_date' => false
            ]],
            [true, "pdp", 0, true, "2017-10-17 00:00:00", [
                'class' => 'unavailable',
                'label' => __('Item due to arrive in stock ' . "<em>" . '%1 %2' . "</em>", ['late', 'October']),
                'has_date' => true
            ]],
            [true, "grouped", 0, true, "2017-10-17 00:00:00", [
                'class' => 'unavailable',
                'label' => __('Item due to arrive in stock ' . "<em>" . '%1 %2' . "</em>", ['late', 'October']),
                'has_date' => true
            ]],
            [true, "plp", 0, true, "2017-10-17 00:00:00", [
                'class' => 'unavailable',
                'label' => __('PRE-ORDER NOW FOR DELIVERY ' . "<em>" . '%1 %2' . "</em>", ['late', 'October']),
                'has_date' => true
            ]],
            [true, "pdp", 0, true, "", [
                'class' => 'unavailable',
                'label' => __("Out of Stock"),
                'has_date' => false
            ]],
        ];
    }

}
