<?php

namespace Space48\ProductAvailability\Test\Unit\Model;

use Magento\CatalogInventory\Api\Data\StockItemInterface;
use Magento\CatalogInventory\Api\StockItemRepositoryInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Catalog\Model\Product;
use Space48\ProductAvailability\Model\PreSell;

class PreSellTest extends \PHPUnit_Framework_TestCase
{
    public $preSell;
    public $objectManager;
    public $productMock;
    public $stockItemRepositoryMock;
    public $stockItemInterfaceMock;

    public function setUp()
    {
        /* StockItemRepository Mock */

        $this->stockItemInterfaceMock = $this->getMockBuilder(
            StockItemInterface::class
        )
            ->disableOriginalConstructor()
            ->getMock();

        $this->stockItemRepositoryMock = $this->getMockBuilder(
            StockItemRepositoryInterface::class
        )
            ->disableOriginalConstructor()
            ->setMethods([
                'get',
                'save',
                'getList',
                'delete',
                'deleteById'
            ])
            ->getMock();

        $this->stockItemRepositoryMock->method('get')->willReturn($this->stockItemInterfaceMock);

        /* PreSell Class */

        $this->objectManager = new ObjectManager($this);

        $this->preSell = $this->objectManager->getObject(
            PreSell::class,
            [
                'StockItemRepository' => $this->stockItemRepositoryMock
            ]
        );

        /* Product Mock */

        $this->productMock = $this->getMockBuilder(Product::class)
            ->setMethods([
                'getPreSell',
                'getPreSellQty',
                'getId',
                'getTypeId'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $this->productMock->method('getId')->willReturn(1);
    }

    public function testReturnsTrueIfNotASimpleProduct()
    {
        $this->productMock->method('getQty')->willReturn(0);
        $this->productMock->method('getTypeId')->willReturn('configurable');
        $this->productMock->method('getPreSellQty')->willReturn(0);

        $this->assertTrue(
            $this->preSell
                ->isProductInStockOrAvailableForPreSale($this->productMock)
        );
    }

    /*public function testReturnsFalseIfSimpleProductAndQtyLessThanZero()
    {
        $this->productMock->method('getQty')->willReturn(0);
        $this->productMock->method('getTypeId')->willReturn('simple');
        $this->productMock->method('getPreSellQty')->willReturn(0);

        $this->assertFalse(
            $this->preSell
                ->isProductInStockOrAvailableForPreSale($this->productMock)
        );
    }*/

    public function testIsValidStockProductReturnsFalseIfProductIsNull()
    {
        $this->assertFalse(
            $this->preSell
                ->isValidStockProduct(null)
        );
    }

    public function testIsValidStockProductReturnsFalseIfProductHasNoTypeId()
    {
        $this->productMock->method('getTypeId')->willReturn(null);

        $this->assertFalse(
            $this->preSell
                ->isValidStockProduct($this->productMock)
        );
    }

    public function testIsValidStockProductReturnsTrueIfProductIsSimple()
    {
        $this->productMock->method('getTypeId')->willReturn('simple');

        $this->assertTrue(
            $this->preSell
                ->isValidStockProduct($this->productMock)
        );
    }

    public function testCanPreSellIfPreSellSetAndPreSellQtyAboveZero()
    {
        $this->productMock->method('getPreSellQty')->willReturn(34);
        $this->productMock->method('getPreSell')->willReturn(true);

        $this->assertTrue($this->preSell->canPreSell($this->productMock));
    }

    public function testCanNotPreSellIfPreSellNotSetAndPreSellQtyAboveZero()
    {
        $this->productMock->method('getPreSellQty')->willReturn(34);
        $this->productMock->method('getPreSell')->willReturn(false);

        $this->assertFalse($this->preSell->canPreSell($this->productMock));
    }

    public function testCanNotPreSellIfPreSellNotSetAndPreSellQtyBelowZero()
    {
        $this->productMock->method('getPreSellQty')->willReturn(0);
        $this->productMock->method('getPreSell')->willReturn(false);

        $this->assertFalse($this->preSell->canPreSell($this->productMock));
    }

    public function testCanNotPreSellIfPreSellNotSet()
    {
        $this->productMock->method('getPreSell')->willReturn(null);

        $this->assertFalse($this->preSell->canPreSell($this->productMock));
    }
}
