<?php

declare(strict_types=1);

namespace App\Tests\Unit\Calculator;

use App\Calculator\OrderSumCalculator;
use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Entity\Product;
use App\Exception\TryingToCalculateSumForOrderWithNotActiveProduct;
use App\Tests\Common\Assert\Calculator\AssertCorrectCalculation;
use App\Tests\Common\TestCase\UnitTestCase;

class OrderSumCalculatorTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->calculator = new OrderSumCalculator();
    }

    public function testItCalculatesTotalSumOfOrder(): void
    {
        $order = $this->getOrderWithActiveProduct();
        $this->calculator->calculate($order);
        AssertCorrectCalculation::assert($order);
    }

    public function testItThrowsExceptionWhenTryingToCalculateProductThatIsNotActive(): void
    {
        $order = $this->getOrderWithNotActiveProduct();
        $this->expectException(TryingToCalculateSumForOrderWithNotActiveProduct::class);
        $this->calculator->calculate($order);
    }

    private function getOrderWithActiveProduct(): OrderInterface
    {
        $order = new Order();
        $order->addProduct((new Product())->setActive(true)->setPrice(10));

        return $order;
    }

    private function getOrderWithNotActiveProduct(): OrderInterface
    {
        $order = new Order();
        $order->addProduct((new Product())->setActive(false)->setPrice(10));

        return $order;
    }
}
