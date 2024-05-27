<?php

namespace App\Entity;

use App\Repository\FournisseurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FournisseurRepository::class)]
class Fournisseur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Titre = null;

    #[ORM\Column(length: 255)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreCateg = null;

    #[ORM\Column(length: 255)]
    private ?string $SousCateg = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->Titre;
    }

    public function setTitre(string $Titre): static
    {
        $this->Titre = $Titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getTitreCateg(): ?string
    {
        return $this->TitreCateg;
    }

    public function setTitreCateg(string $TitreCateg): static
    {
        $this->TitreCateg = $TitreCateg;

        return $this;
    }

    public function getSousCateg(): ?string
    {
        return $this->SousCateg;
    }

    public function setSousCateg(string $SousCateg): static
    {
        $this->SousCateg = $SousCateg;

        return $this;
    }
}
