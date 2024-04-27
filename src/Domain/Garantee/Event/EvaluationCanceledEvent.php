<?php

namespace App\Domain\Garantee\Event;

use App\Domain\Garantee\AttestationInterface;

class EvaluationCanceledEvent
{
    public function __construct(private AttestationInterface $attestation)
    {}

    public function getAttestation(): AttestationInterface
    {
        return $this->attestation;
    }
}