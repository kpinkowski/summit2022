<?php

declare(strict_types=1);

namespace App\Tests\Common\TestCase;

use App\Tests\Common\Util\Fixture\FixtureRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        static::bootKernel();
        $this->startTransaction();
        $this->initializeFixtureRegistry();
    }

    public function tearDown(): void
    {
        FixtureRegistry::clearFixtureCollection();
        $this->rollbackTransaction();
        parent::tearDown();
    }

    protected function get(string $service): ?object
    {
        return $this::$kernel->getContainer()->get($service);
    }

    protected function getEntityManager(): EntityManagerInterface
    {
        return self::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    private function initializeFixtureRegistry(): void
    {
        FixtureRegistry::setEntityManager($this->getEntityManager());
    }

    private function startTransaction(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $connection->beginTransaction();
    }

    private function rollbackTransaction(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        $this->cleanUpDatabase();
        $connection->close();
    }

    private function cleanUpDatabase(): void
    {
        $connection = $this->getEntityManager()->getConnection();
        if ($connection->isTransactionActive()) {
            try {
                while ($connection->getTransactionNestingLevel() > 0) {
                    $connection->rollback();
                }
            } catch (\PDOException $e) {}
        }
    }
}
