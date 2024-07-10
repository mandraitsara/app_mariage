<?php

namespace App\Entity;

use App\Repository\BudgetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BudgetRepository::class)]
class Budget
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $MontantTotal = null;

    #[ORM\Column]
    private ?int $MontantRestant = null;

    #[ORM\OneToOne(inversedBy: 'budget', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserLogin $user_login = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontantTotal(): ?int
    {
        return $this->MontantTotal;
    }

    public function setMontantTotal(int $MontantTotal): static
    {
        $this->MontantTotal = $MontantTotal;

        return $this;
    }

    public function getMontantRestant(): ?int
    {
        return $this->MontantRestant;
    }

    public function setMontantRestant(int $MontantRestant): static
    {
        $this->MontantRestant = $MontantRestant;

        return $this;
    }

    public function getUserLogin(): ?UserLogin
    {
        return $this->user_login;
    }

    public function setUserLogin(UserLogin $user_login): static
    {
        $this->user_login = $user_login;

        return $this;
    }
}
