<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Order;

use App\Entity\Order;
use App\Entity\OrderInterface;
use App\Tests\Common\Util\Fixture\FixtureInterface;

abstract class AbstractOrderFixture implements FixtureInterface
{
    public function create(): OrderInterface
    {
        return new Order();
    }
}
