<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PrestataireRepository;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: PrestataireRepository::class)]
#[Vich\Uploadable]
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

    #[ORM\ManyToOne(inversedBy: 'Prestataires')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Contact $contact = null;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'prestataire', orphanRemoval: true, cascade: ['persist'])]
    private Collection $images;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $imageName = null;

    #[Vich\UploadableField(mapping: 'prestataire_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

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

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;
        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setPrestataire($this);
        }
        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getPrestataire() === $this) {
                $image->setPrestataire(null);
            }
        }
        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;
        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if ($imageFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
