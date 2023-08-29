<?php

namespace App\Domain\Employee\Entity;

use App\Domain\Employee\ROLE;
use App\Domain\Employee\Employee;

class GageManager extends Employee
{
    public function setRoles(array $roles): static
    {
        parent::setRoles([ROLE::CREDIT_MANAGER]);
        return $this;
    }
}