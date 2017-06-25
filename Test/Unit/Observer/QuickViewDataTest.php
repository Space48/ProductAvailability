<?php
/**
 * QuickViewDataTest.php
 *
 * @Date        06/2017
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 * @author      @diazwatson
 */

namespace Space48\ProductAvailability\Observer;

use Magento\Framework\Event\ObserverInterface;

class QuickViewDataTest extends \PHPUnit_Framework_TestCase
{

    public function testItImplementsObserverInterface()
    {
        $observer = $this->getMockBuilder(QuickViewData::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertInstanceOf(ObserverInterface::class, $observer);
    }
}
