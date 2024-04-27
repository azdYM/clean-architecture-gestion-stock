<?php

namespace App\Domain\Garantee\Event;

use Symfony\Contracts\EventDispatcher\Event;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Mounting\Entity\MountingCreditFolderService;

class EvaluationApprovedEvent extends Event
{
    public function __construct(
        private GaranteeAttestation $attestation,
        private MountingCreditFolderService $mountingService,
    ){}

    public function getAttestation(): AttestationInterface
    {
        return $this->attestation;
    }

    public function getSectionLabel(): string
    {
        return $this->mountingService->getServiceName();
    }

    public function getAgencyLabel(): string
    {
        return $this->mountingService
            ->getAgency()
            ->getId()
        ;   
    }
}