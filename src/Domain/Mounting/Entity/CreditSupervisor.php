<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Employee;
use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\CreditApprovedEvent;
use App\Domain\Credit\CreditCanceledEvent;
use App\Domain\Credit\CreditRejectedEvent;
use App\Domain\Credit\ApprovalCreatedEvent;
use App\Domain\Credit\Credit;
use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditRejection;
use App\Domain\Credit\Service\CreditApprovalServiceInterface;
use App\Domain\Credit\Service\CreditRejectionServiceInterface;
use App\Domain\Mounting\WorkingCreditMountingSectionTrait;

#[ORM\Entity]
class CreditSupervisor extends Employee
{
    use WorkingCreditMountingSectionTrait;

    #[ORM\ManyToOne(targetEntity: MountingSection::class, inversedBy: 'supervisors', cascade: ['persist'])]
    #[ORM\JoinColumn(name: 'mounting_section_id', referencedColumnName: 'id')]
    private ?MountingSection $mountingSection = null;

    public function approveCredit(
        CreditApprovalServiceInterface $service, 
        CreditInterface $credit, 
        ?string $comment = null,
        ?Employee $nextApproving = null
    ): CreditApproval
    {
        $approval = $service->approve($credit, $this, $comment);

        if ($nextApproving !== null) {
            $this->event->dispatch(new ApprovalCreatedEvent($approval, $nextApproving));
        } else 
            $this->event->dispatch(new CreditApprovedEvent($credit))
        ; 
        
        return $approval;
    }

    public function rejectCredit(
        CreditRejectionServiceInterface $service, 
        CreditInterface $credit,
        ?string $cause
    ): CreditRejection
    { 
        $rejection = $service->reject($credit, $this, $cause);
        $this->event->dispatch(new CreditRejectedEvent($rejection));
        return $rejection;
    }

    public function cancelCredit(Credit $credit, ?string $cause): CreditInterface
    {
        $credit->canceled($this, $cause);
        $this->event->dispatch(new CreditCanceledEvent($credit));
        return $credit;
    }
}