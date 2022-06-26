<?php

declare(strict_types=1);

namespace App\Tests\Common\Util\Fixture;

class FixtureCollection implements FixtureCollectionInterface
{
    private array $fixtureList = [];

    public function addFixture(string $key, $value): void
    {
        $this->fixtureList[$key] = $value;
    }

    public function removeFixture(string $key): void
    {
        unset($this->fixtureList[$key]);
    }

    public function getFixture(string $key)
    {
        return $this->fixtureList[$key] ?? null;
    }

    public function getList(): array
    {
        return $this->fixtureList;
    }

    public function clearList(): void
    {
        $this->fixtureList = [];
    }
}
