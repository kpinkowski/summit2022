<?php

declare(strict_types=1);

namespace App\Tests\Common\Fixture\Product;

use App\Entity\Product;
use App\Entity\ProductInterface;
use App\Entity\ProductType;
use App\Entity\Stock;
use App\Tests\Common\Util\Fixture\FixtureInterface;
use Faker;

abstract class AbstractProductFixture implements FixtureInterface
{
    public function create(): ProductInterface
    {
        $faker = Faker\Factory::create();

        $product = new Product();
        $product->setName($faker->name);
        $product->setDescription($faker->name);
        $product->setPrice(15);
        $product->setType(ProductType::SIMPLE_PRODUCT->value);
        $product->setActive(false);

        $stock = new Stock();
        $stock->setAmount(12);
        $product->setStock($stock);

        return $product;
    }
}
