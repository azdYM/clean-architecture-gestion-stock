<?php

namespace App\Domain\Employee\Service;

use App\Domain\Credit\Credit;
use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\CreditRejection;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Credit\Event\CreditApprovedEvent;
use App\Domain\Credit\Event\CreditCanceledEvent;
use App\Domain\Credit\Event\CreditRejectedEvent;
use App\Domain\Application\Event\ApprovalCreatedEvent;
use App\Domain\Credit\Service\CreditApprovalServiceInterface;
use App\Domain\Credit\Service\CreditRejectionServiceInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class CreditSupervisionService 
{
    public function __construct
    (
        private Employee $supervisor,
        private EventDispatcherInterface $event
    )
    {}

    public function approveCredit(
        CreditApprovalServiceInterface $service, CreditInterface $credit, ?string $comment = null, ?Employee $nextApproving = null
    ): CreditApproval
    {
        $approval = $service->approve($credit, $this->supervisor, $comment);

        if ($nextApproving !== null) {
            $this->event->dispatch(new ApprovalCreatedEvent($approval, $nextApproving));
        } else 
            $this->event->dispatch(new CreditApprovedEvent($credit))
        ; 
        
        return $approval;
    }

    public function rejectCredit(
        CreditRejectionServiceInterface $service, CreditInterface $credit, ?string $cause
    ): CreditRejection
    { 
        $rejection = $service->reject($credit, $this->supervisor, $cause);
        $this->event->dispatch(new CreditRejectedEvent($rejection));
        return $rejection;
    }

    public function cancelCredit(Credit $credit, ?string $cause): CreditInterface
    {
        $credit->canceled($this->supervisor, $cause);
        $this->event->dispatch(new CreditCanceledEvent($credit));
        return $credit;
    }
}