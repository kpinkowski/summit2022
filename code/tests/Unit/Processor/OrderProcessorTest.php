<?php

declare(strict_types=1);

namespace App\Tests\Unit\Processor;

use App\Calculator\CalculatorInterface;
use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Entity\Product;
use App\Entity\Stock;
use App\Exception\TooManyProductsInOrderException;
use App\Manager\ManagerInterface;
use App\Processor\OrderProcessor;
use App\Tests\Common\Assert\Processor\AssertCorrectOrderStatusChange;
use App\Tests\Common\TestCase\UnitTestCase;
use Doctrine\ORM\EntityManagerInterface;

class OrderProcessorTest extends UnitTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->calculator = $this->createMock(CalculatorInterface::class);
        $this->manager = $this->createMock(ManagerInterface::class);
        $this->processor = new OrderProcessor(
            $this->calculator,
            $this->manager,
            $this->entityManager
        );
    }

    public function testItProcessesOrderCorrectly(): void
    {
        $order = $this->getOrderWithProduct();
        $this->processor->process($order);
        AssertCorrectOrderStatusChange::assert($order);
    }

    public function testItThrowsExceptionWhenThereAreMoreThanTwoProducts(): void
    {
        $order = $this->getOrderWithMultipleProducts();
        $this->expectException(TooManyProductsInOrderException::class);
        $this->processor->process($order);
    }

    public function testItCallsEntityManager(): void
    {
        $order = $this->getOrderWithProduct();
        $this->entityManager
            ->expects(self::exactly(2))
            ->method('persist');

        $this->entityManager
            ->expects(self::once())
            ->method('flush');

        $this->processor->process($order);
    }

    private function getOrderWithProduct(): OrderInterface
    {
        $order = new Order();
        $order->addProduct((new Product())->setStock(new Stock()));

        return $order;
    }

    private function getOrderWithMultipleProducts(): OrderInterface
    {
        $order = $this->getOrderWithProduct();
        $order->addProduct((new Product())->setStock(new Stock()));
        $order->addProduct((new Product())->setStock(new Stock()));

        return $order;
    }
}
