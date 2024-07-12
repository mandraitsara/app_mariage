<?php

namespace App\Entity;

use App\Repository\PrestataireTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrestataireTypeRepository::class)]
class PrestataireType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $titre = null;

    /**
     * @var Collection<int, PrestataireTarif>
     */
    #[ORM\OneToMany(targetEntity: PrestataireTarif::class, mappedBy: 'prestaType')]
    private Collection $prestataireType;

    /**
     * @var Collection<int, PrestataireTarif>
     */
    #[ORM\OneToMany(targetEntity: PrestataireTarif::class, mappedBy: 'prestaType')]
    private Collection $prestaType;

    public function __construct()
    {
        $this->prestataireType = new ArrayCollection();
        $this->prestaType = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * @return Collection<int, PrestataireTarif>
     */
    public function getPrestataireType(): Collection
    {
        return $this->prestataireType;
    }

    public function addPrestataireType(PrestataireTarif $prestataireType): static
    {
        if (!$this->prestataireType->contains($prestataireType)) {
            $this->prestataireType->add($prestataireType);
            $prestataireType->setPrestaType($this);
        }

        return $this;
    }

    public function removePrestataireType(PrestataireTarif $prestataireType): static
    {
        if ($this->prestataireType->removeElement($prestataireType)) {
            // set the owning side to null (unless already changed)
            if ($prestataireType->getPrestaType() === $this) {
                $prestataireType->setPrestaType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PrestataireTarif>
     */
    public function getPrestaType(): Collection
    {
        return $this->prestaType;
    }

    public function addPrestaType(PrestataireTarif $prestaType): static
    {
        if (!$this->prestaType->contains($prestaType)) {
            $this->prestaType->add($prestaType);
            $prestaType->setPrestaType($this);
        }

        return $this;
    }

    public function removePrestaType(PrestataireTarif $prestaType): static
    {
        if ($this->prestaType->removeElement($prestaType)) {
            // set the owning side to null (unless already changed)
            if ($prestaType->getPrestaType() === $this) {
                $prestaType->setPrestaType(null);
            }
        }

        return $this;
    }
}
