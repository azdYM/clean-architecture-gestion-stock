<?php

namespace App\Domain\Application;

use App\Domain\Employee\Entity\Employee;

interface CancellableInterface
{
    public function getCancelledAt(): ?\DateTimeInterface;

    public function setCancelledAt(\DateTimeInterface $canceledAt): static;

    public function getCancellationCause(): string;

    public function setCancellationCause(string $cause): static;

    public function getCancelledBy(): ?Employee;

    public function setCancelledBy(Employee $cancelledBy): self;
}