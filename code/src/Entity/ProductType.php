<?php

declare(strict_types=1);

namespace App\Entity;

enum ProductType: int
{
    case SIMPLE_PRODUCT = 1;
    case VIRTUAL_PRODUCT = 2;
    case CONFIGURABLE_PRODUCT = 3;
}
