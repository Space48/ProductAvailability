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

namespace Space48\ProductAvailability\Block\Catalog\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\Stdlib\DateTime;

class AvailabilityTest extends \PHPUnit_Framework_TestCase
{

    public function testGetAvailability()
    {
        $block = new Availability(new DateTime());

        $availability = $block->getAvailability($this->getProduct());
        $this->assertInternalType('array', $availability);

        $this->assertEquals($this->getSample(),$availability);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject | Product
     */
    private function getProduct()
    {
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $product->method('getData')->with('available_from_x')->willReturn('2017-05-31 00:00:00');

        return $product;
    }

    /**
     * @return array
     */
    private function getSample(): array
    {
        return ['day' => '31', 'early_mid_date' => 'late', 'month' => 'May'];
    }
}
