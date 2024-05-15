<?php

namespace App\Entity;

use App\Repository\AjoutRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AjoutRepository::class)]
class Ajout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
