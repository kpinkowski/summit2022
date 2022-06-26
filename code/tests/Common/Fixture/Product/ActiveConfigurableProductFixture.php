<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Product;

use App\Entity\ProductInterface;
use App\Entity\ProductType;
use App\Tests\Common\Fixture\Product\ActiveSimpleProductFixture;

final class ActiveConfigurableProductFixture extends ActiveSimpleProductFixture
{
    public function create(): ProductInterface
    {
        $product = parent::create();
        $product->setType(ProductType::CONFIGURABLE_PRODUCT->value);

        return $product;
    }
}
