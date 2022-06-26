<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ProductInterface;

interface ManagerInterface
{
    public function increaseStock(ProductInterface $product, int $amount);
    public function decreaseStock(ProductInterface $product, int $amount);
}
