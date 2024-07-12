<?php

namespace App\Entity;

use App\Repository\PrestataireTarifRepository;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'prestataire')]
    private ?Prestataire $prestataire = null;

    #[ORM\ManyToOne(inversedBy: 'prestaType')]
    private ?PrestataireType $prestaType = null;    

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

    public function getPrestataire(): ?Prestataire
    {
        return $this->prestataire;
    }

    public function setPrestataire(?Prestataire $prestataire): static
    {
        $this->prestataire = $prestataire;

        return $this;
    }

    public function getPrestaType(): ?PrestataireType
    {
        return $this->prestaType;
    }

    public function setPrestaType(?PrestataireType $prestaType): static
    {
        $this->prestaType = $prestaType;

        return $this;
    }

    
}
