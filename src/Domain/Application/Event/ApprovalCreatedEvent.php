<?php

namespace App\Domain\Credit;

use App\Domain\Employee\Employee;

class ApprovalCreatedEvent
{
    public function __construct(
        private CreditApproval $approval,
        private ?Employee $nextApproving
    ){}

    public function getApproval(): CreditApproval
    {
        return $this->approval;
    }

    public function getNextApproving(): ?Employee
    {
        return $this->nextApproving;
    }
}