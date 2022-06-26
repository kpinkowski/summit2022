<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\Collection;

interface OrderInterface
{
    public function getId(): ?int;
    public function getStatus(): ?int;
    public function setStatus(int $status): self;
    public function addProduct(Product $product): self;
    public function removeProduct(Product $product): self;
    /** @return Collection<int, Product> */
    public function getProducts(): Collection;
    public function getTotalSum(): ?int;
    public function setTotalSum($totalSum): void;
}
