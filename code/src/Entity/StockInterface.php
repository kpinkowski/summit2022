<?php

declare(strict_types=1);

namespace App\Entity;

interface StockInterface
{
    public function getId(): ?int;
    public function getProduct(): ?Product;
    public function setProduct(Product $product): self;
    public function getAmount(): ?int;
    public function setAmount(int $amount): self;
}
