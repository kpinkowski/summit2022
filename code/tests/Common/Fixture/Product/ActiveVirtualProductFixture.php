<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Product;

use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Entity\ProductType;
use App\Tests\Common\Util\Fixture\FixtureInterface;

class ActiveVirtualProductFixture implements FixtureInterface
{
    public function create(): ProductInterface
    {
        $product = new Product();
        $product->setName('test');
        $product->setDescription('abc');
        $product->setPrice(15);
        $product->setType(ProductType::VIRTUAL_PRODUCT->value);
        $product->setStock(null);
        $product->setActive(true);

        return $product;
    }
}
