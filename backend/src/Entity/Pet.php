<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use App\Repository\PetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Pet
{
    use TimestampableTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private ?string $name = null;


    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dob = null;

    #[ORM\Column]
    private ?bool $approximate_dob = false;

    #[ORM\Column]
    private ?bool $cross_breed = false;

    #[ORM\Column(length: 10)]
    private ?string $gender = null;

    #[ORM\OneToMany(targetEntity: PetBreed::class, mappedBy: 'pet', cascade: ['persist'])]
    private Collection $breed;

    public function __construct()
    {
        $this->breed = new ArrayCollection();
    }


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


    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): static
    {
        $this->dob = $dob;

        return $this;
    }

    public function isApproximateDOB(): ?bool
    {
        return $this->approximate_dob;
    }

    public function setIsApproximate(bool $is_approximate_dob): static
    {
        $this->approximate_dob = $is_approximate_dob;

        return $this;
    }

    public function isCrossBreed(): ?bool
    {
        return $this->cross_breed;
    }

    public function setIsCrossBreed(bool $is_cross_breed): static
    {
        $this->cross_breed = $is_cross_breed;

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

    /**
     * @return Collection<int, PetBreed>
     */
    public function getBreed(): Collection
    {
        return $this->breed;
    }

    public function addBreed(PetBreed $breed): static
    {
        if (!$this->breed->contains($breed)) {
            $this->breed->add($breed);
            $breed->setPet($this);
        }

        return $this;
    }

    public function removeBreed(PetBreed $breed): static
    {
        if ($this->breed->removeElement($breed)) {
            // set the owning side to null (unless already changed)
            if ($breed->getPet() === $this) {
                $breed->setPet(null);
            }
        }

        return $this;
    }
}
