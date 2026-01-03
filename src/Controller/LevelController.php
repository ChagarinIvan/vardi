<?php

namespace App\Controller;

use App\Repository\LevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/levels', name: 'api_levels_')]
final class LevelController extends AbstractController
{
    public function __construct(
        private readonly LevelRepository $levelRepository,
        private readonly SerializerInterface $serializer
    ) {
    }

    #[Route('', name: 'list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $levels = $this->levelRepository->findByOrderIndexAsc();
        $data = $this->serializer->serialize($levels, 'json');

        return new JsonResponse($data, status: Response::HTTP_OK, json: true);
    }
}
