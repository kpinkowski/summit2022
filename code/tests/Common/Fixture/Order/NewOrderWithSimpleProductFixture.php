<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Order;

use App\Entity\OrderInterface;
use App\Entity\Product;
use App\Tests\Common\Fixture\Product\ActiveSimpleProductFixture;
use App\Tests\Common\Util\Fixture\FixtureRegistry;
use App\Tests\Common\Fixture\Product\ActiveVirtualProductFixture;

final class NewOrderWithSimpleProductFixture extends NewOrderFixture
{
    public function create(): OrderInterface
    {
        $order = parent::create();
        /** @var Product $product */
        $product = FixtureRegistry::getFixture(ActiveSimpleProductFixture::class);
        $order->addProduct($product);

        return $order;
    }
}
