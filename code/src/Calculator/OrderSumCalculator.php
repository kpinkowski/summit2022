<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\OrderInterface;
use App\Exception\TryingToCalculateSumForOrderWithNotActiveProduct;

class OrderSumCalculator implements CalculatorInterface
{
    public function calculate(OrderInterface $order): void
    {
        $sum = 0;
        $products = $order->getProducts();
        foreach ($products as $product) {
            if (false === $product->isActive()) {
                throw new TryingToCalculateSumForOrderWithNotActiveProduct();
            }
            $sum += $product->getPrice();
        }

        $order->setTotalSum($sum);
    }
}
