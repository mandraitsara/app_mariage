<?php

namespace App\Entity;

use App\Repository\ActivityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivityRepository::class)]
class Activity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civilité_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $temoin_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civilite_temoin_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $parent_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $amie_proche_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $amie_f = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $parent = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civilite_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $temoin_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $civilite_temoin_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $garcon_d_honneur = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $parent_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ami_h = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ami_proche_h = null;

    #[ORM\ManyToOne(targetEntity: UserLogin::class, inversedBy: 'activities', cascade:['persist'])]
    #[ORM\JoinColumn(nullable: true)]
    private ?UserLogin $user = null;

    // Getters and Setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCivilitéF(): ?string
    {
        return $this->civilité_f;
    }

    public function setCivilitéF(?string $civilité_f): self
    {
        $this->civilité_f = $civilité_f;
        return $this;
    }

    public function getNomF(): ?string
    {
        return $this->nom_f;
    }

    public function setNomF(?string $nom_f): self
    {
        $this->nom_f = $nom_f;
        return $this;
    }

    public function getTemoinF(): ?string
    {
        return $this->temoin_f;
    }

    public function setTemoinF(?string $temoin_f): self
    {
        $this->temoin_f = $temoin_f;
        return $this;
    }

    public function getCiviliteTemoinF(): ?string
    {
        return $this->civilite_temoin_f;
    }

    public function setCiviliteTemoinF(?string $civilite_temoin_f): self
    {
        $this->civilite_temoin_f = $civilite_temoin_f;
        return $this;
    }

    public function getParentF(): ?string
    {
        return $this->parent_f;
    }

    public function setParentF(?string $parent_f): self
    {
        $this->parent_f = $parent_f;
        return $this;
    }

    public function getAmieProcheF(): ?string
    {
        return $this->amie_proche_f;
    }

    public function setAmieProcheF(?string $amie_proche_f): self
    {
        $this->amie_proche_f = $amie_proche_f;
        return $this;
    }

    public function getAmieF(): ?string
    {
        return $this->amie_f;
    }

    public function setAmieF(?string $amie_f): self
    {
        $this->amie_f = $amie_f;
        return $this;
    }

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(?string $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    public function getCiviliteH(): ?string
    {
        return $this->civilite_h;
    }

    public function setCiviliteH(?string $civilite_h): self
    {
        $this->civilite_h = $civilite_h;
        return $this;
    }

    public function getNomH(): ?string
    {
        return $this->nom_h;
    }

    public function setNomH(?string $nom_h): self
    {
        $this->nom_h = $nom_h;
        return $this;
    }

    public function getTemoinH(): ?string
    {
        return $this->temoin_h;
    }

    public function setTemoinH(?string $temoin_h): self
    {
        $this->temoin_h = $temoin_h;
        return $this;
    }

    public function getCiviliteTemoinH(): ?string
    {
        return $this->civilite_temoin_h;
    }

    public function setCiviliteTemoinH(?string $civilite_temoin_h): self
    {
        $this->civilite_temoin_h = $civilite_temoin_h;
        return $this;
    }

    public function getGarconDHonneur(): ?string
    {
        return $this->garcon_d_honneur;
    }

    public function setGarconDHonneur(?string $garcon_d_honneur): self
    {
        $this->garcon_d_honneur = $garcon_d_honneur;
        return $this;
    }

    public function getParentH(): ?string
    {
        return $this->parent_h;
    }

    public function setParentH(?string $parent_h): self
    {
        $this->parent_h = $parent_h;
        return $this;
    }

    public function getAmiH(): ?string
    {
        return $this->ami_h;
    }

    public function setAmiH(?string $ami_h): self
    {
        $this->ami_h = $ami_h;
        return $this;
    }

    public function getAmiProcheH(): ?string
    {
        return $this->ami_proche_h;
    }

    public function setAmiProcheH(?string $ami_proche_h): self
    {
        $this->ami_proche_h = $ami_proche_h;
        return $this;
    }

    public function getUser(): ?UserLogin
    {
        return $this->user;
    }

    public function setUser(?UserLogin $user): self
    {
        $this->user = $user;
        return $this;
    }
}
