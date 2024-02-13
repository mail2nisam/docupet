<?php

namespace App\Controller;

use App\Entity\Breed;
use App\Repository\BreedRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class BreedController extends AbstractController
{
    #[Route('/breed/{type}', methods: ['GET'], name: 'app_breed')]
    public function index(string $type, BreedRepository $breedRepository): JsonResponse
    {

        $breeds = $breedRepository->findByType($type);
        $breedArray = [];
        foreach ($breeds as $breed) {
            $breedArray[] = [
                'id' => $breed->getId(),
                'name' => $breed->getBreed(),
                'is_dangerous' => $breed->isIsDangerous()
            ];
        }
        return $this->json($breedArray);
    }
}
