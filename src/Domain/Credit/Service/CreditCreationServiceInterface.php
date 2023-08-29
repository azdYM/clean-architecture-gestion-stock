<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Employee;
use App\Domain\Mounting\DTO\CreditRequirements;

interface CreditCreationServiceInterface
{
    public function create(CreditRequirements $requirements, Employee $creditAgent): CreditInterface;
}