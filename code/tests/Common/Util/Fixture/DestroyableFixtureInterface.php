<?php

declare(strict_types=1);

namespace App\Tests\Common\Util\Fixture;

interface DestroyableFixtureInterface
{
    public function destroy(): void;
}
