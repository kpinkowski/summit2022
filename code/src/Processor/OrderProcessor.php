<?php

declare(strict_types=1);

namespace App\Processor;

use App\Entity\OrderInterface;
use App\Entity\OrderStatus;
use App\Calculator\CalculatorInterface;
use App\Exception\TooManyProductsInOrderException;
use App\Manager\ManagerInterface;
use Doctrine\ORM\EntityManagerInterface;

class OrderProcessor implements ProcessorInterface
{
    private CalculatorInterface $orderSumCalculator;
    private ManagerInterface $stockManager;
    private EntityManagerInterface $entityManager;

    public function __construct(
        CalculatorInterface $orderSumCalculator,
        ManagerInterface $stockManager,
        EntityManagerInterface $entityManager
    ) {
        $this->orderSumCalculator = $orderSumCalculator;
        $this->stockManager = $stockManager;
        $this->entityManager = $entityManager;
    }

    public function process(OrderInterface $order): void
    {
        if ($order->getProducts()->count() > 2) {
            throw new TooManyProductsInOrderException();
        }

        foreach ($order->getProducts() as $product) {
            $this->stockManager->decreaseStock($product, 1);
            $this->entityManager->persist($product->getStock());
        }
        sleep(1);
        $order->setStatus(OrderStatus::PLACED->value);
        $this->orderSumCalculator->calculate($order);
        $this->entityManager->persist($order);
        $this->entityManager->flush();
    }
}
