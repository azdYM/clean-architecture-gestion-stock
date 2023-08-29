<?php

namespace App\Domain\Mounting\DTO;

use App\Domain\Customer\ClientInterface;
use App\Domain\Garantee\Entity\Attestation;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\AttestationInterface;
use Doctrine\Common\Collections\ArrayCollection;

class FolderRequirements
{
    /** @var Collection<int, AttestationInterface> $attestations */
    public Collection $attestations;

    public ClientInterface $client;

    public function __construct()
    {
        $this->attestations = new ArrayCollection();
    }

    /**
     * @return Collection<int, AttestationInterface>
     */
    public function getAttestations(): Collection
    {
        return $this->attestations;
    }

    public function addAttestation(Attestation $attestation): self
    {
        if (!$this->attestations->contains($attestation)) {
            $this->attestations->add($attestation);
        }

        return $this;
    }

    public function getClient(): ClientInterface
    {
        return $this->attestations->first()->getClient();
    }
}