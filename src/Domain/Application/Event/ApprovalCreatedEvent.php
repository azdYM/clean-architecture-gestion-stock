<?php

namespace App\Domain\Application\Event;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Credit\Entity\CreditApproval;

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