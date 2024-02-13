<?php

namespace App\Entity;

use App\Repository\PetBreedRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetBreedRepository::class)]
class PetBreed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'breed', cascade: ['persist'])]
    private ?Pet $pet = null;

    #[ORM\ManyToOne(inversedBy: 'petBreeds', cascade: ['persist'])]
    private ?Breed $breed = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPet(): ?Pet
    {
        return $this->pet;
    }

    public function setPet(?Pet $pet): static
    {
        $this->pet = $pet;

        return $this;
    }

    public function getBreed(): ?Breed
    {
        return $this->breed;
    }

    public function setBreed(?Breed $breed): static
    {
        $this->breed = $breed;

        return $this;
    }
}
