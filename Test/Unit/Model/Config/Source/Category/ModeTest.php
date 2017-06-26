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

namespace Space48\ProductAvailability\Model\Config\Source\Category;

use Magento\Framework\Option\ArrayInterface;

class ModeTest extends \PHPUnit_Framework_TestCase
{

    private $mode;

    public function setUp()
    {
        $this->mode = new Mode();
    }

    public function testModeReturn()
    {
        $optionArrayExpected = [['value' => 1, 'label' => __('Custom')], ['value' => 0, 'label' => __('Default')]];
        $toArray = [0 => __('Default'), 1 => __('Custom')];

        $this->assertEquals($optionArrayExpected, $this->mode->toOptionArray());
        $this->assertEquals($toArray, $this->mode->toArray());
    }

    public function testModeImplementInterface()
    {
        $this->assertInstanceOf(ArrayInterface::class, $this->mode);
    }
}
