<?php

namespace App\Tests\Controller;

use App\Controller\WordController;
use App\DataFixtures\LevelFixtures;
use App\DataFixtures\WordFixtures;
use App\Tests\ApiTestCase;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Constraint\Count;
use Symfony\Component\HttpFoundation\Response;

#[CoversMethod(className: WordController::class, methodName: 'list')]
class ListWordsControllerTest extends ApiTestCase
{
    #[Test]
    public function it_gets_words_list(): void
    {
        $this->loadFixtures(LevelFixtures::class, WordFixtures::class);

        $this->app->request('GET', '/api/words');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertResponseInJsonFormat();
        $this->assertResponseMatchesJsonConstraints([
            '$' => new Count(1),
            '$.0.latvian' => 'vards',
            '$.0.russian' => 'слово',
        ]);
    }
}
