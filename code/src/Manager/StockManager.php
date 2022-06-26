<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ProductInterface;
use App\Entity\ProductType;
use App\Exception\NegativeStockException;

class StockManager implements ManagerInterface
{
    public function increaseStock(ProductInterface $product, int $amount): void
    {
        if (ProductType::VIRTUAL_PRODUCT->value !== $product->getType()) {
            $stock = $product->getStock();
            $newStockAmount = $stock->getAmount() + $amount;
            $stock->setAmount($newStockAmount);
        }
    }

    public function decreaseStock(ProductInterface $product, int $amount): void
    {
        if (ProductType::VIRTUAL_PRODUCT->value !== $product->getType()) {
            $stock = $product->getStock();
            $newStockAmount = $stock->getAmount() - $amount;

            if ($newStockAmount < 0) {
                throw new NegativeStockException();
            }

            $stock->setAmount($newStockAmount);
        }
    }
}
