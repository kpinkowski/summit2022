<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Order;

use App\Entity\OrderInterface;
use App\Entity\OrderStatus;

class NewOrderFixture extends AbstractOrderFixture
{
    public function create(): OrderInterface
    {
        $order = parent::create();
        $order->setStatus(OrderStatus::NEW->value);

        return $order;
    }
}
