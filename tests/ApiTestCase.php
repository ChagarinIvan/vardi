<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Helmich\JsonAssert\Constraint\JsonValueMatchesMany;
use Helmich\JsonAssert\Constraint\JsonValueMatchesSchema;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class ApiTestCase extends WebTestCase
{
    protected const string FORMAT_JSON = 'json';

    protected KernelBrowser $app;
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->app = self::createClient();

        /** @var EntityManagerInterface $em */
        $em = $this->app->getContainer()->get(EntityManagerInterface::class);
        $this->em = $em;
    }

    protected function assertResponseInJsonFormat(): void
    {
        self::assertResponseFormatSame(self::FORMAT_JSON);
    }

    protected function assertResponseMatchesJsonConstraints(array $constraints): void
    {
        self::assertThat($this->app->getResponse()->getContent(), new JsonValueMatchesMany($constraints));
    }

    protected function assertResponseMatchesJsonSchema(array $schema): void
    {
        self::assertThat($this->app->getResponse()->getContent(), new JsonValueMatchesSchema($schema));
    }

    protected function loadFixtures(string... $fixtures): void
    {
        $loader = new Loader();
        foreach ($fixtures as $fixture) {
            $loader->addFixture(new $fixture());
        }

        $executor = new ORMExecutor($this->em, new ORMPurger($this->em));
        $executor->execute($loader->getFixtures());
    }
}
