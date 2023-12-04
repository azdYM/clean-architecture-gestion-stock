<?php

namespace App\Domain\Garantee\Event;

use App\Domain\Garantee\Entity\GaranteeAttestation;
use Symfony\Contracts\EventDispatcher\Event;

class EvaluationCreatedEvent extends Event
{
    public function __construct(
        private GaranteeAttestation $attestation, 
    ){}

    public function getAttestation(): GaranteeAttestation
    {
        return $this->attestation;
    }

    public function getSectionLabel(): string
    {
        return $this->attestation
            ->getEvaluationService()
            ->getServiceName()
        ;
    }

    public function getAgency(): int
    {
        return $this->attestation
            ->getEvaluationService()
            ->getAgency()
            ->getId()
        ;
    }
}