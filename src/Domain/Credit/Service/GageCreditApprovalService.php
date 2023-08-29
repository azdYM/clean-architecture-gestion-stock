<?php

namespace App\Domain\Credit\Service;

use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditInterface;
use App\Domain\Employee\Employee;

class GageCreditApprovalService implements CreditApprovalServiceInterface
{
    public function approve(CreditInterface $credit, Employee $supervisor, ?string $comment = null): CreditApproval
    {
        return $credit->approved($supervisor, $comment);
    }
}