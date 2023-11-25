<?php

namespace App\Http\Api\DTO\Garantee;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\Client;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Employee\Entity\Employee;
use App\Http\Api\DTO\Customer\Corporate;
use App\Domain\Garantee\Entity\Gold\Gold;
use App\Http\Api\DTO\Customer\Individual;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Provider\AttestationProvider;
use App\Http\Api\State\Processor\AttestationProcessor;

#[ApiResource(
    processor: AttestationProcessor::class,
    provider: AttestationProvider::class,
    operations: [
        new Get(
            uriTemplate: '/attestation/{id}', 
            normalizationContext: [
                'groups' => [
                    'General:read',
                    'Attestations:read', 
                    'Attestation:read',
                    'Location:read',
                    'Contact:read',
                    'Client:read'
                ]
            ]          
        ),
        new GetCollection(
            uriTemplate: '/attestations',
            normalizationContext: [
                'groups' => [
                    'General:read',
                    'Attestations:read', 
                ]
            ]  
        ),
    ]
)]
class Attestation
{
    #[Groups(['Attestations:read'])]
    public ?int $id = null;

    #[Groups(['Attestations:read', 'Client:read'])]
    public ?Client $client = null;
    
    /** @var array<int, Gold> */
    #[Groups(['Attestations:read'])]
    public array $items;

    #[Groups(['Attestation:read'])]
    public Employee $evaluator;

    #[Groups(['Attestation:read'])]
    public ?string $evaluatorDescription = null;

    #[Groups(['Attestation:read'])]
    public ?int $idCreditTypeTargeted = null;

    #[Groups(['Attestation:read'])]
    public bool $canUpdate = false;
    
    #[Groups(['Attestations:read'])]
    public ?string $currentPlace = null;

    #[Groups(['Attestations:read', 'Attestations:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}