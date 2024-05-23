<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\ORM\Mapping as ORM;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrestataire(): ?string
    {
        return $this->NomPrestataire;
    }

    public function setNomPrestataire(string $NomPrestataire): static
    {
        $this->NomPrestataire = $NomPrestataire;

        return $this;
    }

    public function getTypePrestataire(): ?string
    {
        return $this->TypePrestataire;
    }

    public function setTypePrestataire(string $TypePrestataire): static
    {
        $this->TypePrestataire = $TypePrestataire;

        return $this;
    }

    public function getInfoPrestataire(): ?string
    {
        return $this->infoPrestataire;
    }

    public function setInfoPrestataire(string $infoPrestataire): static
    {
        $this->infoPrestataire = $infoPrestataire;

        return $this;
    }
}
