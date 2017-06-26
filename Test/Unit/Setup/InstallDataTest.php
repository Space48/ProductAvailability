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

namespace Space48\ProductAvailability\Setup;

use Magento\Eav\Setup\EavSetupFactory;
use Magento\Framework\Setup\InstallDataInterface;

class InstallDataTest extends \PHPUnit_Framework_TestCase
{

    public function testItIsInstanceOf()
    {
        $setup = $this->getSetup();
        $this->assertInstanceOf(InstallDataInterface::class, $setup);
    }

    private function getSetup()
    {
        /** @var \Magento\Eav\Setup\EavSetupFactory $stubEavSetupFactory */
        $stubEavSetupFactory = $this->getMockBuilder(EavSetupFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $setup = new InstallData($stubEavSetupFactory);

        return $setup;
    }
}
