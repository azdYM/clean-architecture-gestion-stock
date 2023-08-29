<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Customer\Entity\Person;
use App\Domain\Customer\ClientInterface;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'attestation' => Attestation::class, 
    'gold' => GoldAttestation::class]
)]
abstract class Attestation implements AttestationInterface
{
    use IdentifiableTrait;

    #[ORM\ManyToOne(targetEntity: Person::class)]
    #[ORM\JoinColumn(name: 'client_id', referencedColumnName: 'id')]
    protected ClientInterface $client;

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): static
    {
        $this->client = $client;
        return $this;
    }
}