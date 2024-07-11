<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_h = null;


    #[ORM\ManyToOne(targetEntity: UserLogin::class, inversedBy: 'activities', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?UserLogin $user = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dateCeremonie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LieuxCeremonie = null;

    #[ORM\Column(nullable: true)]
    private ?string $dateAt = null;

    #[ORM\Column(nullable: true, length: 255)]
    private ?string $jourJ = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $budgetInitial = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $budgetRestant = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    #[ORM\JoinColumn(nullable: false)]



    // Getters and Setters...

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getNomF(): ?string
    {
        return $this->nom_f;
    }

    public function setNomF(?string $nom_f): self
    {
        $this->nom_f = $nom_f;
        return $this;
    }


    public function getNomH(): ?string
    {
        return $this->nom_h;
    }

    public function setNomH(?string $nom_h): self
    {
        $this->nom_h = $nom_h;
        return $this;
    }

    public function getDateCeremonie(): ?string
    {
        return $this->dateCeremonie;
    }

    public function setDateCeremonie(?string $dateCeremonie): static
    {
        $this->dateCeremonie = $dateCeremonie;

        return $this;
    }

    public function getLieuxCeremonie(): ?string
    {
        return $this->LieuxCeremonie;
    }

    public function setLieuxCeremonie(?string $LieuxCeremonie): static
    {
        $this->LieuxCeremonie = $LieuxCeremonie;

        return $this;
    }

    public function getDateAt(): string
    {
        return $this->dateAt;
    }

    public function setDateAt(?string $dateAt): static
    {
        $this->dateAt = $dateAt;

        return $this;
    }

    public function getJourJ(): ?string
    {
        return $this->jourJ;
    }

    public function setJourJ(string $jourJ): static
    {
        $this->jourJ = $jourJ;

        return $this;
    }

    public function getUser(): ?UserLogin
    {
        return $this->user;
    }

    public function setUser(?UserLogin $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getBudgetInitial(): ?string
    {
        return $this->budgetInitial;
    }

    public function setBudgetInitial(?string $budgetInitial): static
    {
        $this->budgetInitial = $budgetInitial;

        return $this;
    }

    public function getBudgetRestant(): ?string
    {
        return $this->budgetRestant;
    }

    public function setBudgetRestant(?string $budgetRestant): static
    {
        $this->budgetRestant = $budgetRestant;

        return $this;
    }
}
