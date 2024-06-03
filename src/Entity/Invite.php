<?php

namespace App\Entity;

use App\Repository\InviteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InviteRepository::class)]
class Invite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nominvite = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNominvite(): ?string
    {
        return $this->nominvite;
    }

    public function setNominvite(string $nominvite): static
    {
        $this->nominvite = $nominvite;

        return $this;
    }
}
