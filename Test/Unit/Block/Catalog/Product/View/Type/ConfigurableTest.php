<?php
/**
 * ConfigurableTest.php
 *
 * @Date        07/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

namespace Space48\ProductAvailability\Block\Catalog\Product\View\Type;

use Magento\Catalog\Helper\Product as ProductHelper;
use Magento\Catalog\Model\Product;
use Magento\CatalogInventory\Api\StockStateInterface;
use Magento\ConfigurableProduct\Helper\Data;
use Magento\ConfigurableProduct\Model\ConfigurableAttributeData;
use Magento\Customer\Helper\Session\CurrentCustomer;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\Phrase;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Framework\Stdlib\DateTime;
use Magento\Catalog\Block\Product\Context;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;
use Space48\PreSell\Block\PreSell;

class ConfigurableTest extends \PHPUnit_Framework_TestCase
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

        return $product;
    }

    public function testReturnedMessageIsInstanceOf()
    {
        $availability = $this->getBlock()->getAvailability($this->product);
        $this->assertInstanceOf(Phrase::class, $availability['label']);
    }

    /**
     * @return Configurable
     */
    private function getBlock()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject | Context $contextMock */
        $contextMock = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | ArrayUtils $arrayUtilsMock */
        $arrayUtilsMock = $this->getMockBuilder(ArrayUtils::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | EncoderInterface $jsonEncoderMock */
        $jsonEncoderMock = $this->getMockBuilder(EncoderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | Data $confProductHelperMock */
        $confProductHelperMock = $this->getMockBuilder(Data::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | ProductHelper $productHelperMock */
        $productHelperMock = $this->getMockBuilder(ProductHelper::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | CurrentCustomer $currentCustomerMock */
        $currentCustomerMock = $this->getMockBuilder(CurrentCustomer::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | PriceCurrencyInterface $priceCurrencyInterfaceMock */
        $priceCurrencyInterfaceMock = $this->getMockBuilder(PriceCurrencyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | ConfigurableAttributeData $confAttributeDataMock */
        $confAttributeDataMock = $this->getMockBuilder(ConfigurableAttributeData::class)
            ->disableOriginalConstructor()
            ->getMock();

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

        $block = new Configurable(
            $contextMock,
            $arrayUtilsMock,
            $jsonEncoderMock,
            $confProductHelperMock,
            $productHelperMock,
            $currentCustomerMock,
            $priceCurrencyInterfaceMock,
            $confAttributeDataMock,
            $availability
        );

        return $block;
    }

    public function testGetAvailabilityForPdpProduct()
    {
        $availability = $this->getBlock()->getAvailability($this->product, 'pdp');
        $expected = __('Item due to arrive in stock %1 %2', ['late', 'May']);
        $PdpAvailabilityMessage = $availability['label'];

        $this->assertEquals($expected, $PdpAvailabilityMessage);
    }

    public function testGetAvailabilityForPlpProduct()
    {
        $availability = $this->getBlock()->getAvailability($this->product, 'plp');
        $expected = __('PRE-ORDER NOW FOR DELIVERY %1 %2', ['late', 'May']);
        $PdpAvailabilityMessage = $availability['label'];

        $this->assertEquals($expected, $PdpAvailabilityMessage);
    }
}
