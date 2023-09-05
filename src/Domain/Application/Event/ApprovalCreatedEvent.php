<?php

namespace App\Domain\Application\Event;

use App\Domain\Credit\CreditApproval;
use App\Domain\Employee\Entity\Employee;

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