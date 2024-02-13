<?php

namespace App\Entity;

use App\Repository\BreedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BreedRepository::class)]
class Breed
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $breed = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PetType $type = null;

    #[ORM\Column]
    private ?bool $is_dangerous = false;

    #[ORM\OneToMany(targetEntity: PetBreed::class, mappedBy: 'breed')]
    private Collection $petBreeds;

    public function __construct()
    {
        $this->petBreeds = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getType(): ?PetType
    {
        return $this->type;
    }

    public function setType(?PetType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function isIsDangerous(): ?bool
    {
        return $this->is_dangerous;
    }

    public function setIsDangerous(bool $is_dangerous): static
    {
        $this->is_dangerous = $is_dangerous;

        return $this;
    }

    /**
     * @return Collection<int, PetBreed>
     */
    public function getPetBreeds(): Collection
    {
        return $this->petBreeds;
    }

    public function addPetBreed(PetBreed $petBreed): static
    {
        if (!$this->petBreeds->contains($petBreed)) {
            $this->petBreeds->add($petBreed);
            $petBreed->setBreed($this);
        }

        return $this;
    }

    public function removePetBreed(PetBreed $petBreed): static
    {
        if ($this->petBreeds->removeElement($petBreed)) {
            // set the owning side to null (unless already changed)
            if ($petBreed->getBreed() === $this) {
                $petBreed->setBreed(null);
            }
        }

        return $this;
    }
}
