<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Order;

use App\Entity\OrderInterface;
use App\Entity\Product;
use App\Tests\Common\Fixture\Product\ActiveVirtualProductFixture;
use App\Tests\Common\Util\Fixture\FixtureRegistry;

final class NewOrderWithVirtualProductFixture extends NewOrderFixture
{
    public function create(): OrderInterface
    {
        $order = parent::create();
        /** @var Product $product */
        $product = FixtureRegistry::getFixture(ActiveVirtualProductFixture::class);
        $order->addProduct($product);

        return $order;
    }
}
