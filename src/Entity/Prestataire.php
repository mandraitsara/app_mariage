<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
class Prestataire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $NomPrestataire = null;

    #[ORM\Column(length: 255)]
    private ?string $TypePrestataire = null;

    #[ORM\Column(length: 255)]
    private ?string $infoPrestataire = null;

    #[ORM\ManyToOne(inversedBy: 'Prestataires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'Prestataire')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrestataire(): ?string
    {
        return $this->NomPrestataire;
    }

    public function setNomPrestataire(string $NomPrestataire): self
    {
        $this->NomPrestataire = $NomPrestataire;

        return $this;
    }

    public function getTypePrestataire(): ?string
    {
        return $this->TypePrestataire;
    }

    public function setTypePrestataire(string $TypePrestataire): self
    {
        $this->TypePrestataire = $TypePrestataire;

        return $this;
    }

    public function getInfoPrestataire(): ?string
    {
        return $this->infoPrestataire;
    }

    public function setInfoPrestataire(string $infoPrestataire): self
    {
        $this->infoPrestataire = $infoPrestataire;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }
}
