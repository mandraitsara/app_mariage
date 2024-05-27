<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TitreCategorie = null;

    #[ORM\Column(length: 255)]
    private ?string $SoustitreCategorie = null;

    #[ORM\Column(length: 255)]
    private ?string $Content = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreCategorie(): ?string
    {
        return $this->TitreCategorie;
    }

    public function setTitreCategorie(string $TitreCategorie): static
    {
        $this->TitreCategorie = $TitreCategorie;

        return $this;
    }

    public function getSoustitreCategorie(): ?string
    {
        return $this->SoustitreCategorie;
    }

    public function setSoustitreCategorie(string $SoustitreCategorie): static
    {
        $this->SoustitreCategorie = $SoustitreCategorie;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(string $Content): static
    {
        $this->Content = $Content;

        return $this;
    }
}
