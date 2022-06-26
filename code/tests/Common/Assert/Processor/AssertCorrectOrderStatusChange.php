<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert\Processor;

use App\Entity\OrderInterface;
use App\Entity\OrderStatus;
use PHPUnit\Framework\Assert;

class AssertCorrectOrderStatusChange
{
    public static function assert(OrderInterface $order)
    {
        Assert::assertSame(OrderStatus::PLACED->value, $order->getStatus());
    }
}
