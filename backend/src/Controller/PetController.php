<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Entity\Breed;
use App\Entity\PetBreed;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PetController extends AbstractController
{

    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    #[Route('/pet', methods: ['GET'], name: 'app_pet')]
    public function index(EntityManagerInterface $entityManager,): JsonResponse
    {
        $pets = $entityManager->getRepository(Pet::class)->findAllWithBreedAndType();
        $responseData = [];
        foreach ($pets as $pet) {
            $responseData[] = $this->serializePet($pet);
        }

        return new JsonResponse($responseData);
    }

    #[Route('/pet/{id}', methods: ['GET'], name: 'app_pet_details')]
    public function show(Pet $id, EntityManagerInterface $entityManager,): JsonResponse
    {
        $pet = $entityManager->getRepository(Pet::class)->find($id);

        $responseData = $this->serializePet($pet);


        return new JsonResponse($responseData);
    }

    /**
     * Serialize output
     */
    private function serializePet(Pet $pet): array
    {
        $petData = [
            'id' => $pet->getId(),
            'name' => $pet->getName(),
            'dob' => $pet->getDob()->format('Y-m-d'),
            'is_approximate_dob' => $pet->isApproximateDOB(),
            'gender' => $pet->getGender(),
            'cross_breed' => $pet->isCrossBreed()
        ];

        $breedsData = [];
        foreach ($pet->getBreed() as $petBreed) {
            $breed = $petBreed->getBreed();
            if ($breed) {
                $breedsData[] = [
                    'id' => $breed->getId(),
                    'name' => $breed->getBreed(),
                    'is_dangerous' => $breed->isIsDangerous(),
                    'type' => [
                        'id' => $breed->getType()->getId(),
                        'name' => $breed->getType()->getType()
                    ],
                ];
            }
        }

        $petData['breeds'] = $breedsData;

        return $petData;
    }

    #[Route('/pet', methods: ['POST'], name: 'app_new_pet')]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $selectedBreeds = isset($data['breed']) ? $data['breed'] : [];
        $breeds = [];
        if($selectedBreeds){
            $breeds  = $entityManager->getRepository(Breed::class)->findBy(['id' => $selectedBreeds]);
            if (!$breeds) {
                return new JsonResponse(['error' => 'Breed not found'], Response::HTTP_NOT_FOUND);
            }
        }

        $dob = '';

        $isApproximateBirthDate = false;
        if (array_key_exists('dob', $data)) {
            $birthDate = $data['dob'];
            $dob = DateTime::createFromFormat('Y-m-d\TH:i:s.u\Z', $birthDate);
        } else {
            if (array_key_exists('age', $data)) {
                $currentDate = new DateTime();
                $birthDate = $currentDate->sub(new DateInterval("P{$data['age']}Y"));
                $isApproximateBirthDate = true;
                $dob = $birthDate;
            }
        }

        $pet = new Pet();
        $pet->setName($data['name']);
        $pet->setGender($data['gender']);
        $pet->setIsCrossBreed(isset($data['is_cross_breed'])? $data['is_cross_breed']: false );

        foreach ($breeds as $breed) {
            $petBreed = new PetBreed();
            $petBreed->setPet($pet);
            $petBreed->setBreed($breed);
            $pet->addBreed($petBreed);
        }

        $pet->setDob($dob);
        $pet->setIsApproximate($isApproximateBirthDate);

        $errors = $validator->validate($pet);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;
            return new JsonResponse(['message' => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($pet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Pet created successfully'], Response::HTTP_CREATED);
    }
}
