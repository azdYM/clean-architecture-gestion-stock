<?php

namespace App\Domain\Employee\Service;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Garantee\Entity\AttestationApproval;
use App\Domain\Garantee\Entity\AttestationRejection;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Event\EvaluationApprovedEvent;
use App\Domain\Garantee\Event\EvaluationCanceledEvent;
use App\Domain\Mounting\Entity\MountingCreditFolderService;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class GageSupervisionService
{
    public function __construct
    (
        private Employee $supervisor,
        private EventDispatcherInterface $event
    ){}

    public function approve(
        GoldAttestation $attestation, MountingCreditFolderService $serviceMountingTargeted, ?string $comment = null
    ): AttestationApproval
    {   
        $approval = $attestation->approved($this->supervisor, $comment);
        $this->event->dispatch(
            new EvaluationApprovedEvent($attestation, $serviceMountingTargeted)
        );

        return $approval;
    }

    public function reject(GoldAttestation $attestation, ?string $cause): AttestationRejection
    {
        $rejection = $attestation->rejected($this->supervisor, $cause);
        $this->event->dispatch(new EvaluationCanceledEvent($attestation));
        return $rejection;
    }

    public function cancel(GoldAttestation $attestation, ?string $cause): AttestationInterface
    {
        $attestation->canceled($this->supervisor, $cause);
        $this->event->dispatch(new EvaluationCanceledEvent($attestation));
        return $attestation;
    }
}