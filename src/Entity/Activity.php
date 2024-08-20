<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: ActivityRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $budgetPrestataire = null;

    #[ORM\Column(nullable: true)]
    private ?int $id_prestateur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lieuxDeReception = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhotoReception = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhotoPrincipal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PhotoCeremonie = null;

    #[ORM\Column(nullable: true)]
    private ?int $PhoneHomme = null;

    #[ORM\Column(nullable: true)]
    private ?int $PhoneFemme = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sloganTexte = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fichierCsv = null;
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

    public function getBudgetPrestataire(): ?string
    {
        return $this->budgetPrestataire;
    }

    public function setBudgetPrestataire(?string $budgetPrestataire): static
    {
        $this->budgetPrestataire = $budgetPrestataire;

        return $this;
    }

    public function getIdPrestateur(): ?int
    {
        return $this->id_prestateur;
    }

    public function setIdPrestateur(?int $id_prestateur): static
    {
        $this->id_prestateur = $id_prestateur;

        return $this;
    }

    public function getLieuxDeReception(): ?string
    {
        return $this->lieuxDeReception;
    }

    public function setLieuxDeReception(?string $lieuxDeReception): static
    {
        $this->lieuxDeReception = $lieuxDeReception;

        return $this;
    }

    public function getPhotoReception(): ?String
    {
        return $this->PhotoReception;
    }

    public function setPhotoReception(?String $PhotoReception): static
    {
        $this->PhotoReception = $PhotoReception;
        return $this;
    }

    public function getPhotoPrincipal(): ?string
    {
        return $this->PhotoPrincipal;
    }

    public function setPhotoPrincipal(?string $PhotoPrincipal): static
    {
        $this->PhotoPrincipal = $PhotoPrincipal;

        return $this;
    }

    public function getPhotoCeremonie(): ?string
    {
        return $this->PhotoCeremonie;
    }

    public function setPhotoCeremonie(?string $PhotoCeremonie): static
    {
        $this->PhotoCeremonie = $PhotoCeremonie;

        return $this;
    }

    public function getPhoneHomme(): ?int
    {
        return $this->PhoneHomme;
    }

    public function setPhoneHomme(?int $PhoneHomme): static
    {
        $this->PhoneHomme = $PhoneHomme;

        return $this;
    }

    public function getPhoneFemme(): ?int
    {
        return $this->PhoneFemme;
    }

    public function setPhoneFemme(?int $PhoneFemme): static
    {
        $this->PhoneFemme = $PhoneFemme;

        return $this;
    }

    public function getSloganTexte(): ?string
    {
        return $this->sloganTexte;
    }

    public function setSloganTexte(?string $sloganTexte): static
    {
        $this->sloganTexte = $sloganTexte;

        return $this;
    }

    public function getFichierCsv(): ?string
    {
        return $this->fichierCsv;
    }

    public function setFichierCsv(?string $fichierCsv): static
    {
        $this->fichierCsv = $fichierCsv;

        return $this;
    }

}
