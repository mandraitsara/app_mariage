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
    private ?string $nomF = null;

    #[ORM\Column(length: 255)]
    private ?string $TypeF = null;

    #[ORM\Column(length: 255)]
    private ?string $Contact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomF(): ?string
    {
        return $this->nomF;
    }

    public function setNomF(string $nomF): static
    {
        $this->nomF = $nomF;

        return $this;
    }

    public function getTypeF(): ?string
    {
        return $this->TypeF;
    }

    public function setTypeF(string $TypeF): static
    {
        $this->TypeF = $TypeF;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->Contact;
    }

    public function setContact(string $Contact): static
    {
        $this->Contact = $Contact;

        return $this;
    }
}
