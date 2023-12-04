<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Credit\Entity\CreditApproval;

interface CreditApprovalServiceInterface
{
    public function approve(CreditInterface $credit, Employee $supervisor, ?string $comment = null): CreditApproval;
}