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

#[CoversMethod(className: WordController::class, methodName: 'create')]
class AddWordControllerTest extends ApiTestCase
{
    #[Test]
    public function it_adds_word(): void
    {
        $this->loadFixtures(LevelFixtures::class);

        $this->app->jsonRequest('POST', '/api/words', [
            'latvian' => 'vards',
            'russian' => 'слово',
            'level' => 'A1',
            'partOfSpeech' => 'noun',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertResponseInJsonFormat();

        $this->assertResponseMatchesJsonConstraints([
            '$.latvian' => 'vards',
            '$.russian' => 'слово',
            '$.level.code' => 'A1',
        ]);
    }

    #[Test]
    public function it_validates_request(): void
    {
        $this->app->jsonRequest('POST', '/api/words', [
            'latvian' => 'vards',
            'russian' => 'слово',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
        $this->assertResponseInJsonFormat();

        $this->assertResponseMatchesJsonConstraints([
            '$.title' => 'Validation Failed',
            '$.violations' => new Count(2),
        ]);
    }

    #[Test]
    public function it_validates_level_code(): void
    {
        $this->app->jsonRequest('POST', '/api/words', [
            'latvian' => 'vards',
            'russian' => 'слово',
            'level' => 'A1',
            'partOfSpeech' => 'noun',
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
