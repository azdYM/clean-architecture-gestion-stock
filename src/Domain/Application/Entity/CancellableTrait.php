<?php

namespace App\Domain\Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;

trait CancellableTrait
{
    #[ORM\Column(type: 'datetime', nullable: true)]
    protected ?\DateTimeInterface $cancelledAt = null;

    #[ORM\Column(length: 255, nullable: true)]
    protected ?string $cancellationCause = null;

    #[ORM\ManyToOne(targetEntity: Employee::class)]
    #[ORM\JoinColumn(name: 'cancelled_by_employe_id', referencedColumnName: 'id')]
    private ?Employee $cancelledBy;

    public function getCancelledAt(): ?\DateTimeInterface
    {
        return $this->cancelledAt;
    }

    public function setCancelledAt(\DateTimeInterface $cancelledAt): static
    {
        $this->cancelledAt = $cancelledAt;
        return $this;
    }

    public function getCancellationCause(): string
    {
        return $this->cancellationCause;
    }

    public function setCancellationCause(string $cause): static
    {
        $this->cancellationCause = $cause;
        return $this;
    }

    public function getCancelledBy(): ?Employee
    {
        return $this->cancelledBy;
    }

    public function setCancelledBy(Employee $cancelledBy): self
    {
        $this->cancelledBy = $cancelledBy;
        return $this;
    }
}