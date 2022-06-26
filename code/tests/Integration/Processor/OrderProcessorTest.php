<?php

declare(strict_types=1);

namespace App\Tests\Integration\Processor;

use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Processor\OrderProcessor;
use App\Tests\Common\Fixture\Order\NewOrderWithConfigurableProductFixture;
use App\Tests\Common\TestCase\IntegrationTestCase;
use App\Tests\Common\Util\Fixture\FixtureRegistry;
use App\Tests\Common\Assert\Calculator\AssertCorrectCalculation;
use App\Tests\Common\Assert\Processor\AssertCorrectOrderStatusChange;
use App\Tests\Common\Assert\StockManager\AssertCorrectStockDecrease;
use App\Tests\Common\Fixture\Order\NewOrderWithSimpleProductFixture;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Assert;

class OrderProcessorTest extends IntegrationTestCase
{
    private EntityManagerInterface $entityManager;
    private OrderProcessor $orderProcessor;

    public function setUp(): void
    {
        parent::setUp();
        $this->entityManager = $this->get('doctrine.orm.entity_manager');
        $this->orderProcessor = $this->get(OrderProcessor::class);
    }

    public function testItProcessesOrderCorrectly(): void
    {
        /** @var OrderInterface $order */
        $order = FixtureRegistry::getFixture(NewOrderWithSimpleProductFixture::class);

        $this->orderProcessor->process($order);
        $this->entityManager->refresh($order);

        AssertCorrectOrderStatusChange::assert($order);
    }

    public function testCalculatesCorrectTotalSumOfOrder(): void
    {
        /** @var OrderInterface $order */
        $order = FixtureRegistry::getFixture(NewOrderWithSimpleProductFixture::class);

        $this->orderProcessor->process($order);
        $this->entityManager->refresh($order);

        AssertCorrectCalculation::assert($order);
        $orders = $this->entityManager->getRepository(Order::class)->findAll();
        Assert::assertCount(1, $orders);
    }

    /** @dataProvider ordersWithNotVirtualProductsProvider */
    public function testItDecreasesStockForProductsOtherThanVirtual(string $fixtureClass): void
    {
        /** @var OrderInterface $order */
        $order = FixtureRegistry::getFixture($fixtureClass);
        $initialStocks = $this->getInitialStocksOfProductsInOrder($order);

        $this->orderProcessor->process($order);

        foreach ($order->getProducts() as $product) {
            $this->entityManager->refresh($product);
            AssertCorrectStockDecrease::assert($product, $initialStocks[$product->getId()]);
        }
    }

    public function ordersWithNotVirtualProductsProvider(): array
    {
        return [
            [NewOrderWithSimpleProductFixture::class],
            [NewOrderWithConfigurableProductFixture::class],
        ];
    }

    private function getInitialStocksOfProductsInOrder(OrderInterface $order): array
    {
        $initialStocks = [];
        foreach ($order->getProducts() as $product) {
            $initialStocks[$product->getId()] = $product->getStock()->getAmount();
        }

        return $initialStocks;
    }
}
