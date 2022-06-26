<?php

declare(strict_types=1);

namespace App\Tests\Unit\Manager;

use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Entity\ProductType;
use App\Entity\Stock;
use App\Exception\NegativeStockException;
use App\Manager\StockManager;
use App\Tests\Common\Assert\StockManager\AssertCorrectStockDecrease;
use App\Tests\Common\Assert\StockManager\AssertCorrectStockIncrease;
use PHPUnit\Framework\TestCase;

class StockManagerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->stockManager = new StockManager();
    }

    public function testItIncreasesStockAmount(): void
    {
        $initialStock = 1;
        $product = $this->getSimpleProduct($initialStock);
        $this->stockManager->increaseStock($product, 1);
        AssertCorrectStockIncrease::assert($product, $initialStock);
    }

    public function testItDecreasesStockAmount(): void
    {
        $initialStock = 1;
        $product = $this->getSimpleProduct($initialStock);
        $this->stockManager->decreaseStock($product, 1);
        AssertCorrectStockDecrease::assert($product, $initialStock);
    }

    public function testItThrowsExceptionWhenTryingToSetStockAmountBelowZero(): void
    {
        $initialStock = 1;
        $product = $this->getSimpleProduct($initialStock);
        $this->expectException(NegativeStockException::class);
        $this->stockManager->decreaseStock($product, 2);
    }

    private function getSimpleProduct($initialStock): ProductInterface
    {
        $product = new Product();
        $product->setType(ProductType::SIMPLE_PRODUCT->value);
        $stock = new Stock();
        $stock->setAmount($initialStock);
        $product->setStock($stock);

        return $product;
    }
}
