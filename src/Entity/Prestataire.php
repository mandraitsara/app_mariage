<?php

namespace App\Entity;

use App\Repository\PrestataireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
class Prestataire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contact = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * @var Collection<int, PrestataireTarif>
     */
    #[ORM\OneToMany(targetEntity: PrestataireTarif::class, mappedBy: 'prestataire')]
    private Collection $prestataire;    
    

    #[ORM\Column(nullable: true)]
    private ?string $budgetPrestataire = null;

    public function __construct()
    {
        $this->prestataire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id):static
    {
        $this->id = $id;
        
        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

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

    /**
     * @return Collection<int, PrestataireTarif>
     */
    public function getPrestataire(): Collection
    {
        return $this->prestataire;
    }

    public function addPrestataire(PrestataireTarif $prestataire): static
    {
        if (!$this->prestataire->contains($prestataire)) {
            $this->prestataire->add($prestataire);
            $prestataire->setPrestataire($this);
        }

        return $this;
    }

    public function removePrestataire(PrestataireTarif $prestataire): static
    {
        if ($this->prestataire->removeElement($prestataire)) {
            // set the owning side to null (unless already changed)
            if ($prestataire->getPrestataire() === $this) {
                $prestataire->setPrestataire(null);
            }
        }

        return $this;
    }

    public function getPrestataireTarif(): ?PrestataireTarif
    {
        return $this->prestataireTarif;
    }

    public function setPrestataireTarif(?PrestataireTarif $prestataireTarif): static
    {
        $this->prestataireTarif = $prestataireTarif;

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
}
