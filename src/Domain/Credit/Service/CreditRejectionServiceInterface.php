<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Credit\Entity\CreditRejection;

interface CreditRejectionServiceInterface
{
    public function reject(CreditInterface $credit, Employee $supervisor, string $cause): CreditRejection;
}