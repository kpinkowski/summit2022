<?php

declare(strict_types=1);

namespace App\Processor;

use App\Entity\OrderInterface;

interface ProcessorInterface
{
    public function process(OrderInterface $order);
}
