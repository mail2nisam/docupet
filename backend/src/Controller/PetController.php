<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Entity\PetBreed;
use App\Entity\PetType;
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
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/PetController.php',
        ]);
    }

    #[Route('/pet', methods:['POST'], name: 'app_new_pet')]

    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        // Process and validate the request data
        $data = json_decode($request->getContent(), true);
        // Validate $data using Symfony's validation component
        // dd($data);
        // Create and persist the new pet entity



        $breed = $entityManager->getRepository(PetBreed::class)->find($data['breed']);

        if (!$breed) {
            // Handle the case where the PetType with the provided ID is not found
            return new JsonResponse(['error' => 'PetType not found'], Response::HTTP_NOT_FOUND);
        }
        $dob = '';

        $isApproximateBirthDate = false;
        if (array_key_exists('dob', $data)) {
            $birthDate= $data['dob'];
            $dob = DateTime::createFromFormat('Y-m-d', $birthDate);

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
        $pet->setBreed($breed);
        $pet->setDob($dob);
        $pet->setIsApproximate($isApproximateBirthDate);

        $errors = $validator->validate($pet);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;
            return new JsonResponse(['message'=> $errorsString], Response::HTTP_BAD_REQUEST);

            // return new Response($errorsString);
        }
        // Set properties of $pet based on $data

        $entityManager->persist($pet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Pet created successfully'], Response::HTTP_CREATED);
    }
}
