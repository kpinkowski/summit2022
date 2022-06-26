<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Product;

use App\Entity\ProductInterface;

class ActiveSimpleProductFixture extends AbstractProductFixture
{
    public function create(): ProductInterface
    {
        $product = parent::create();
        $product->setActive(true);

        return $product;
    }
}
