<?php

namespace App\Http\Api\DTO\Garantee;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\Client;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Gold\Gold;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Provider\AttestationProvider;
use App\Http\Api\State\Processor\ApprovalAttestationProcessor;
use App\Http\Api\State\Processor\RejectionAttestationProcessor;
use App\Http\Api\State\Processor\ValidationAttestationProcessor;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    provider: AttestationProvider::class,
    normalizationContext: ['groups' => [
        'Attestations:read'
    ]],
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
        new Post(
            uriTemplate: '/attestation/{id}/validate',
            processor: ValidationAttestationProcessor::class,
            stateless: false,
            security: 'is_granted("ROLE_GAGE_EVALUATOR")',
        ),
        new Post(
            uriTemplate: '/attestation/{id}/reject',
            stateless: false,
            denormalizationContext: ['groups' => ['Attestation:reject']],
            processor: RejectionAttestationProcessor::class,
            security: 'is_granted("ROLE_GAGE_SUPERVISOR")',
        ),
        new Post(
            uriTemplate: '/attestation/{id}/approve',
            stateless: false,
            denormalizationContext: ['groups' => ['Attestation:write']],
            processor: ApprovalAttestationProcessor::class,
            security: 'is_granted("ROLE_GAGE_SUPERVISOR")',
        ),
        new Post(
            uriTemplate: '/attestation/{id}/cancel',
            denormalizationContext: ['groups' => ['Attestation:write']],
            stateless: false,
        )
    ]
)]
class Attestation
{
    #[Groups([
        'Attestations:read', 
        'Folder:write', 
        'Folder:read',
    ])]
    public ?int $id = null;

    #[Groups(['Attestations:read'])]
    public ?Client $client = null;
    
    /** @var array<int, Gold> */
    #[Groups(['Attestations:read', 'Folder:read'])]
    public array $items;

    #[Groups(['Attestation:read'])]
    public Employee $evaluator;

    #[Groups(['Attestation:read'])]
    public ?string $evaluatorDescription = null;

    #[Groups(['Attestation:read'])]
    public ?int $idCreditTypeTargeted = null;

    #[Groups(['Attestation:read'])]
    public bool $canEdit = false;

    #[Groups(['Attestation:read'])]
    public bool $canPrint = false;

    #[Groups(['Attestations:read'])]
    public bool $canMountCredit = false;
    
    #[Groups(['Attestations:read'])]
    public ?string $currentPlace = null;

    #[Assert\NotBlank(message: 'Ce champ ne doit pas être null')]
    #[Assert\NotBlank(message: 'Ce champ ne doit pas être vide')]
    #[Groups(['Attestation:reject'])]
    public ?string $rejectionCause = null;

    #[Groups(['Attestations:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}