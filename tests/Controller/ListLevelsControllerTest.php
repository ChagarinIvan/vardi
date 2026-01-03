<?php

namespace App\Tests\Controller;

use App\Controller\LevelController;
use App\Controller\WordController;
use App\DataFixtures\LevelFixtures;
use App\DataFixtures\WordFixtures;
use App\Tests\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Constraint\Count;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

#[CoversMethod(className: LevelController::class, methodName: 'list')]

class ListLevelsControllerTest extends ApiTestCase
{
    #[Test]
    public function it_gets_levels_list(): void
    {
        $this->loadFixtures(LevelFixtures::class);

        $this->app->request('GET', '/api/levels');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseInJsonFormat();

        $this->assertResponseMatchesJsonConstraints([
            '$' => new Count(1),
            '$.0.code' => 'A1',
        ]);
    }
}
