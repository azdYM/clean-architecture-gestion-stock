<?php

namespace App\Domain\Auth\Entity;

use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Auth\User;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class LoginAttempt
{
    use IdentifiableTrait;

    #[ORM\ManyToOne(targetEntity: \App\Domain\Auth\User::class)]
    #[ORM\JoinColumn(onDelete: 'CASCADE')]
    private User $user;

    #[ORM\Column(name: 'datetime')]
    private \DateTime $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
