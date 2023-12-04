<?php

namespace App\Domain\Customer\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Customer\Repository\ContactRepository;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    use IdentifiableTrait;

    #[ORM\Column(length: 50, unique: true, nullable: true)]
    #[Groups(['Contact:read'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 50, unique: true, nullable: true)]
    #[Groups(['Contact:read'])]
    private ?string $email = null;

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}