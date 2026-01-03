<?php

namespace App\Controller;

use App\Dto\WordDto;
use App\Entity\Level;
use App\Entity\PartOfSpeech;
use App\Entity\Word;
use App\Repository\LevelRepository;
use App\Repository\WordRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/words', name: 'api_words_')]
final class WordController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly WordRepository $words,
        private readonly LevelRepository $levels,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(Request $request): JsonResponse
    {
        $levelId = $request->query->get('level_id');
        $data = $this->serializer->serialize($levelId
            ? $this->words->findBy(['level' => $levelId])
            : $this->words->findAll()
        , 'json');

        return new JsonResponse($data, status: Response::HTTP_OK, json: true);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(
        #[MapRequestPayload(validationFailedStatusCode: 400)]
        WordDto $dto,
    ): JsonResponse {
        /** @var Level $level */
        $level = $this->levels->findOneBy(['code' => $dto->level]) ?? throw new NotFoundHttpException();

        $word = new Word(
            latvian: $dto->latvian,
            russian: $dto->russian,
            level: $level,
            partOfSpeech: PartOfSpeech::from($dto->partOfSpeech),
            imageUrl: $dto->imageUrl,
        );

        $this->em->persist($word);
        $this->em->flush();

        $response = $this->serializer->serialize($word, 'json');

        return new JsonResponse($response, Response::HTTP_CREATED,  json: true);
    }
}
