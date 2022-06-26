<?php

declare(strict_types=1);

namespace App\Entity;

enum OrderStatus: int
{
    case NEW = 1;
    case PLACED = 2;
}
