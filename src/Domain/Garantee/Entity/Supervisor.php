<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\GageSection;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Garantee\Entity\AttestationApproval;
use App\Domain\Garantee\Entity\AttestationRejection;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Event\EvaluationApprovedEvent;
use App\Domain\Garantee\Event\EvaluationCanceledEvent;
use App\Domain\Garantee\WorkingEvaluationSectionTrait;
use App\Domain\Mounting\Entity\MountingCreditFolderService;

#[ORM\Entity]
class Supervisor extends Employee
{
    use WorkingEvaluationSectionTrait;

    #[ORM\ManyToOne(targetEntity: GageSection::class, inversedBy: 'supervisors')]
    #[ORM\JoinColumn(name: 'gage_section_id', referencedColumnName: 'id')]
    private ?GageSection $gageSection = null;

    public function approve(GoldAttestation $attestation, MountingCreditFolderService $serviceMountingTargeted, ?string $comment = null): AttestationApproval
    {   
        $approval = $attestation->approved($this, $comment);
        $this->event->dispatch(
            new EvaluationApprovedEvent($attestation, $serviceMountingTargeted)
        );

        return $approval;
    }

    public function reject(GoldAttestation $attestation, ?string $cause): AttestationRejection
    {
        $rejection = $attestation->rejected($this, $cause);
        $this->event->dispatch(new EvaluationCanceledEvent($attestation));
        return $rejection;
    }

    public function cancel(GoldAttestation $attestation, ?string $cause): AttestationInterface
    {
        $attestation->canceled($this, $cause);
        $this->event->dispatch(new EvaluationCanceledEvent($attestation));
        return $attestation;
    }
}