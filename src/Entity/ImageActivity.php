<?php

namespace App\Entity;

use App\Repository\ImageActivityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageActivityRepository::class)]
class ImageActivity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $idActivity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ceremonieImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $receptionImage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $principaleImage = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdActivity(): ?int
    {
        return $this->idActivity;
    }

    public function setIdActivity(?int $idActivity): static
    {
        $this->idActivity = $idActivity;

        return $this;
    }

    public function getCeremonieImage(): ?string
    {
        return $this->ceremonieImage;
    }

    public function setCeremonieImage(?string $ceremonieImage): static
    {
        $this->ceremonieImage = $ceremonieImage;

        return $this;
    }

    public function getReceptionImage(): ?string
    {
        return $this->receptionImage;
    }

    public function setReceptionImage(?string $receptionImage): static
    {
        $this->receptionImage = $receptionImage;

        return $this;
    }

    public function getPrincipaleImage(): ?string
    {
        return $this->principaleImage;
    }

    public function setPrincipaleImage(?string $principaleImage): static
    {
        $this->principaleImage = $principaleImage;

        return $this;
    }
}
