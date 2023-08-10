<?php

namespace App\Domain\Employee;

trait TraitEmployee
{
    public function getRoles(): array
    {
        $this->roles[] = ROLE::USER;
        return array_unique($this->roles);
    }
}