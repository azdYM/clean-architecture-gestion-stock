<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\CreditRejection;
use App\Domain\Employee\Employee;

interface CreditRejectionServiceInterface
{
    public function reject(CreditInterface $credit, Employee $supervisor, string $cause): CreditRejection;
}