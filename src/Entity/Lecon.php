<?php

namespace App\Entity;

use App\Repository\LeconRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeconRepository::class)]
class Lecon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 50)]
    private ?string $heure = null;



    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicule $immatriculation = null;

    #[ORM\Column]
    private ?int $reglee = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'lecons')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }



    public function getImmatriculation(): ?Vehicule
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?Vehicule $immatriculation): self
    {
        $this->immatriculation = $immatriculation;

        return $this;
    }

    public function getReglee(): ?int
    {
        return $this->reglee;
    }

    public function setReglee(int $reglee): self
    {
        $this->reglee = $reglee;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(User $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
        }

        return $this;
    }

    public function removeRelation(User $relation): self
    {
        $this->relation->removeElement($relation);

        return $this;
    }


}