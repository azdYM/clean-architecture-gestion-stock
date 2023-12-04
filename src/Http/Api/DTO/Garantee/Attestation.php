<?php

namespace App\Http\Api\DTO\Garantee;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\Client;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Gold\Gold;
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
    #[Groups(['Attestations:read', 'Folder:write', 'Folder:read'])]
    public ?int $id = null;

    #[Groups(['Attestations:read'])]
    public ?Client $client = null;
    
    /** @var array<int, Gold> */
    #[Groups(['Attestations:read', 'Folder:read'])]
    public array $items;

    #[Groups(['Attestation:read'])]
    public Employee $evaluator;

    #[Groups(['Attestation:read', 'Folder:read'])]
    public ?string $evaluatorDescription = null;

    #[Groups(['Attestation:read'])]
    public ?int $idCreditTypeTargeted = null;

    #[Groups(['Attestation:read'])]
    public bool $canUpdate = false;

    #[Groups(['Attestations:read', 'Folder:read'])]
    public bool $canMountCredit = false;
    
    #[Groups(['Attestations:read'])]
    public ?string $currentPlace = null;

    #[Groups(['Attestations:read', 'Attestations:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}