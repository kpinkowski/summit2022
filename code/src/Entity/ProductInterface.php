<?php

declare(strict_types=1);

namespace App\Entity;

interface ProductInterface
{
    public function getId(): ?int;
    public function isActive(): ?bool;
    public function setActive(bool $active): self;
    public function getDescription(): ?string;
    public function setDescription(?string $description): self;
    public function getName(): ?string;
    public function setName(string $name): self;
    public function getPrice(): ?int;
    public function setPrice(int $price): self;
    public function getType(): int;
    public function setType(int $type): self;
    public function getStock(): ?StockInterface;
    public function setStock(?StockInterface $stock);
}
