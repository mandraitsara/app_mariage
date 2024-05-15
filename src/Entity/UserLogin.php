<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Mime\Message;
use App\Repository\UserLoginRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserLoginRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'L\'adresse email est déjà utilisée.')]
class UserLogin implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email(message: "L'adresse email n'est pas valide.")]
    #[Assert\NotBlank(message: "L'adresse email ne peut pas être vide.")]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Le mot de passe ne peut pas être vide.")]
    #[Assert\Length(min: 8, minMessage: "Votre mot de passe doit contenir 8 caractères minimum.")]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $test = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function eraseCredentials(): void
    {

    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }
    
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getTest(): ?string
    {
        return $this->test;
    }

    public function setTest(string $test): static
    {
        $this->test = $test;

        return $this;
    }
}
