<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\Entity\Credit;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\DTO\CreditRequirements;

interface CreditCreationServiceInterface
{
    public function create(CreditRequirements $requirements, Employee $creditAgent): Credit;
}