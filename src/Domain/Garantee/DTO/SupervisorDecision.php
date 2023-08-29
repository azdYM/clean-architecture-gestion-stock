<?php

namespace App\Domain\Garantee\DTO;

class SupervisorDecision
{
    public bool $accepted;

    public ?string $description = null;

    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}