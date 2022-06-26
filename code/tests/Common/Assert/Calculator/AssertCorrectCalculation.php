<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert\Calculator;

use App\Entity\OrderInterface;
use PHPUnit\Framework\Assert;

class AssertCorrectCalculation
{
    public static function assert(OrderInterface $order): void
    {
        $sum = 0;
        $products = $order->getProducts();
        foreach ($products as $product) {
            $sum += $product->getPrice();
        }

        Assert::assertSame($sum, $order->getTotalSum());
    }
}
