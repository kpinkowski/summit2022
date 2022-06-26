<?php

declare(strict_types=1);

namespace App\Calculator;

use App\Entity\OrderInterface;

interface CalculatorInterface
{
    public function calculate(OrderInterface $order): void;
}
