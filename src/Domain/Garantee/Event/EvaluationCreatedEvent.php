<?php

namespace App\Domain\Garantee\Event;

use App\Domain\Garantee\AttestationInterface;
use App\Domain\Garantee\Entity\EvaluationGageService;
use Symfony\Contracts\EventDispatcher\Event;

class EvaluationCreatedEvent extends Event
{
    public function __construct(
        private AttestationInterface $attestation, 
        private EvaluationGageService $evaluationService
    ){}

    public function getAttestation(): AttestationInterface
    {
        return $this->attestation;
    }

    public function getSectionLabel(): string
    {
        return $this->evaluationService->getServiceName();
    }

    public function getAgencyLabel(): string
    {
        return $this->evaluationService
            ->getAgency()
            ->getLabel()
        ;   
    }
}