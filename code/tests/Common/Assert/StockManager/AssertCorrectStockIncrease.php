<?php

declare(strict_types=1);

namespace App\Tests\Common\Assert\StockManager;

use App\Entity\ProductInterface;
use App\Entity\ProductType;
use PHPUnit\Framework\Assert;

class AssertCorrectStockIncrease
{
    public static function assert(ProductInterface $product, int $initialStock): void
    {
        if (ProductType::VIRTUAL_PRODUCT === $product->getType()) {
            throw new \Exception('This assertion should not be performed for VirtualProduct type');
        }

        Assert::assertSame($product->getStock()->getAmount(), $initialStock + 1);
    }
}
