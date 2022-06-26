<?php

declare(strict_types=1);

namespace App\Tests\Common\Util\Fixture;

interface FixtureCollectionInterface
{
    public function addFixture(string $key, $value): void;
    public function removeFixture(string $key): void;
    public function getFixture(string $key);
    public function getList(): array;
    public function clearList(): void;
}
