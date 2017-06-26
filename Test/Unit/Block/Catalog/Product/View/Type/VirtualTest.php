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

namespace Space48\ProductAvailability\Test\Block\Catalog\Product\View\Type;

use Magento\Catalog\Block\Product\Context;
use \Magento\Catalog\Block\Product\View\AbstractView;
use Magento\Catalog\Model\Product;
use Magento\Framework\Phrase;
use Magento\Framework\Stdlib\ArrayUtils;
use Magento\Framework\Stdlib\DateTime;
use Space48\ProductAvailability\Block\Catalog\Product\Availability;
use Space48\ProductAvailability\Block\Catalog\Product\View\Type\Virtual;

class VirtualTest extends \PHPUnit_Framework_TestCase
{

    public function testIsInstanceOfVirtual()
    {
        $this->assertInstanceOf(AbstractView::class, $this->getBlock());
    }

    private function getBlock()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject | Context $stubContext */
        $stubContext = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | ArrayUtils $stubArrayUtils */
        $stubArrayUtils = $this->getMockBuilder(ArrayUtils::class)->getMock();

        /** @var \PHPUnit_Framework_MockObject_MockObject | Availability $availability */
        $availability = new Availability(new DateTime());

        return new Virtual($stubContext, $stubArrayUtils, $availability);
    }

    public function testGetAvailabilityReturnType()
    {
        $this->assertInstanceOf(Phrase::class, $this->getBlock()->getAvailability($this->getProduct()));
    }

    /**
     *
     * @return \PHPUnit_Framework_MockObject_MockObject | Product
     */
    private function getProduct()
    {
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $product;
    }
}
