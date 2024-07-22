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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'prestataire', cascade:['persist'])]
    private ?Prestataire $prestataire = null;

    #[ORM\ManyToOne(inversedBy: 'prestaType')]
    private ?PrestataireType $prestaType = null;

    /**
     * @var Collection<int, Prestataire>
     */
    #[ORM\OneToMany(targetEntity: Prestataire::class, mappedBy: 'prestataireTarif')]
    private Collection $prestataires;

    public function __construct()
    {
        $this->prestataires = new ArrayCollection();
    }    

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

    /**
     * @return Collection<int, Prestataire>
     */
    public function getPrestataires(): Collection
    {
        return $this->prestataires;
    }

    public function addPrestataire(Prestataire $prestataire): static
    {
        if (!$this->prestataires->contains($prestataire)) {
            $this->prestataires->add($prestataire);
            $prestataire->setPrestataireTarif($this);
        }

        return $this;
    }

    public function removePrestataire(Prestataire $prestataire): static
    {
        if ($this->prestataires->removeElement($prestataire)) {
            // set the owning side to null (unless already changed)
            if ($prestataire->getPrestataireTarif() === $this) {
                $prestataire->setPrestataireTarif(null);
            }
        }

        return $this;
    }

    
}
