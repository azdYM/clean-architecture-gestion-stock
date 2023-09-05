<?php

namespace App\Domain\Garantee\Event;

use App\Domain\Garantee\Entity\Attestation;
use Symfony\Contracts\EventDispatcher\Event;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Mounting\Entity\MountingCreditFolderService;

class EvaluationApprovedEvent extends Event
{
    public function __construct(
        private Attestation $attestation,
        private MountingCreditFolderService $mountingService,
    ){}

    public function getAttestation(): AttestationInterface
    {
        return $this->getAttestation();
    }

    public function getSectionLabel(): string
    {
        return $this->mountingService->getServiceName();
    }

    public function getAgencyLabel(): string
    {
        return $this->mountingService
            ->getAgency()
            ->getLabel()
        ;   
    }
}