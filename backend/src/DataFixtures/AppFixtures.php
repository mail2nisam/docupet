<?php

namespace App\DataFixtures;

use App\Entity\PetBreed;
use App\Entity\PetType;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private $entityManager;


    public function __construct(UserPasswordHasherInterface  $hasher, EntityManagerInterface $entityManager)
    {
        $this->hasher = $hasher;
        $this->entityManager = $entityManager;
    }
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user->setEmail('admin@example.com');

        $user->setFullName('Admin User');
        $user->setUsername('admin');

        $password = $this->hasher->hashPassword($user, 'pass_1234');
        $user->setPassword($password);
        $manager->persist($user);


        $catType = new PetType();
        $catType->setType('Cat');
        $manager->persist($catType);

        // Create dog type
        $dogType = new PetType();
        $dogType->setType('Dog');
        $manager->persist($dogType);

        // Flush types to generate IDs
        $manager->flush();

        $cats = [
            'Siamese',
            'Persian',
            'Maine Coon',
            'British Shorthair',
            'Bengal'
        ];

        foreach ($cats as $cat) {
            $breedEntity = new PetBreed();
            $breedEntity->setType($catType);
            $breedEntity->setBreed($cat);
            $manager->persist($breedEntity);
        }


        $dogs = [
            ['name' => 'Labrador Retriever', 'is_dangerous' => false],
            ['name' => 'German Shepherd', 'is_dangerous' => false],
            ['name' => 'Golden Retriever', 'is_dangerous' => false],
            ['name' => 'Poodle', 'is_dangerous' => false],
            ['name' => 'Bulldog', 'is_dangerous' => false],
            ['name' => 'Pitbull', 'is_dangerous' => true],
            ['name' => 'Rottweiler', 'is_dangerous' => true],
            ['name' => 'Doberman Pinscher', 'is_dangerous' => true],
            ['name' => 'German Shepherd', 'is_dangerous' => true],
            ['name' => 'Siberian Husky', 'is_dangerous' => false],
            ['name' => 'unknown', 'is_dangerous' => false],
            ['name' => 'mix', 'is_dangerous' => false]

        ];

        foreach ($dogs as $dog) {
            $breedEntity = new PetBreed();
            $breedEntity->setType($dogType);
            $breedEntity->setBreed($dog['name']);
            $breedEntity->setIsDangerous($dog['is_dangerous']);
            $manager->persist($breedEntity);
        }
        $manager->flush();
    }
}
