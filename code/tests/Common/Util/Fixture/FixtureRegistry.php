<?php

declare(strict_types=1);

namespace App\Tests\Common\Util\Fixture;

use Doctrine\ORM\EntityManagerInterface;

class FixtureRegistry
{
    private static ?FixtureCollectionInterface $fixtureCollection = null;
    private static ?EntityManagerInterface $em = null;

    public static function getFixture(string $className): object
    {
        return (static::getInstance()->getFixture($className)) ?: self::loadMissingFixture($className);
    }

    private static function loadMissingFixture(string $className): ?object
    {
        $fixture = new $className();
        $object = $fixture->create();
        static::$em->persist($object);
        static::$em->flush($object);
        static::addFixture($className, $object);

        return $object;
    }

    public static function clearFixtureCollection(): void
    {
        foreach (static::getInstance()->getList() as $className => $fixtureObject) {
            $fixture = new $className();
            if ($fixture instanceof DestroyableFixtureInterface) {
                $fixture->destroy();
            }
        }

        static::getInstance()->clearList();
    }

    public static function addFixture(string $className, $value): void
    {
        static::getInstance()->addFixture($className, $value);
    }

    public static function removeFixture(string $className): void
    {
        static::getInstance()->removeFixture($className);
    }

    public static function setEntityManager(EntityManagerInterface $em): void
    {
        static::$em = $em;
    }

    private static function getInstance(): FixtureCollectionInterface
    {
        if (static::$fixtureCollection === null) {
            static::$fixtureCollection = new FixtureCollection();
        }

        return static::$fixtureCollection;
    }
}
