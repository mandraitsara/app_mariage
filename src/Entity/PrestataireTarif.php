<?php

namespace App\Entity;

use App\Repository\PrestataireTarifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestataireTarifRepository::class)]
class PrestataireTarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $prix = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]    private ?string $description = null;

 

    #[ORM\Column(nullable: true)]
    private ?int $prestaId = null;

    #[ORM\Column(nullable: true)]
    private ?int $typeId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;
     

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(?float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

 
  

    public function getPrestaId(): ?int
    {
        return $this->prestaId;
    }

    public function setPrestaId(?int $prestaId): static
    {
        $this->prestaId = $prestaId;

        return $this;
    }

    public function getTypeId(): ?int
    {
        return $this->typeId;
    }

    public function setTypeId(?int $typeId): static
    {
        $this->typeId = $typeId;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }
    
}
