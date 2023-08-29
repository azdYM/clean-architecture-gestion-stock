<?php

namespace App\Domain\Employee;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Notification\Entity\Notifiable;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Employee\Repository\EmployeeRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'disc', type: 'string')]
#[ORM\DiscriminatorMap([
    'employe' => Employee::class,
    'gold_evaluator' => \App\Domain\Garantee\Entity\Evaluator::class,
    'gold_supervisor' => \App\Domain\Garantee\Entity\Supervisor::class,
    'credit_agent' => \App\Domain\Mounting\Entity\CreditAgent::class,
    'credit_supervisor' => \App\Domain\Mounting\Entity\CreditSupervisor::class
])]
class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    use IdentifiableTrait;
    use TimestampTrait;
    use Notifiable;

    #[ORM\Column(length: 180, unique: true)]
    protected ?string $email = null;

    #[ORM\Column(length: 180)]
    protected ?string $username = null;

    #[ORM\Column]
    protected array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    protected ?string $password = null;

    protected EventDispatcherInterface $event;

    public function __construct()
    {
        $this->setRoles([]);
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * Obtenir l'email de l'utilisateur
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        //$this->roles[] = ROLE::USER;
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function setEvent(EventDispatcherInterface $event)
    {
        $this->event = $event;
    }
}
