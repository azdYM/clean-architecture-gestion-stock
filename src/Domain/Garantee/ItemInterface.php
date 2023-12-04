<?php

namespace App\Domain\Garantee;

interface ItemInterface
{
    public function setAttestation(AttestationInterface $attestation): self;

    public function getAttestation(): AttestationInterface;
}