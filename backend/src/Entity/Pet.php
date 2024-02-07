<?php

namespace App\Entity;

use App\Repository\PetRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PetRepository::class)]
class Pet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?PetType $type = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?PetBreed $breed = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\Column]
    private ?bool $is_approximate = null;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getType(): ?PetType
    {
        return $this->type;
    }

    public function setType(PetType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getBreed(): ?PetBreed
    {
        return $this->breed;
    }

    public function setBreed(?PetBreed $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function isIsApproximate(): ?bool
    {
        return $this->is_approximate;
    }

    public function setIsApproximate(bool $is_approximate): static
    {
        $this->is_approximate = $is_approximate;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }
}
