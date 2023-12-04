<?php

namespace App\Http\Api\DTO\Garantee;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\Garantee\Entity\Gold\Gold;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Processor\GoldEvaluationStateProcessor;

#[ApiResource(
    processor: GoldEvaluationStateProcessor::class,
    normalizationContext: [
        'groups' => [
            'GoldEvaluation:read', 
            'Attestation:read', 
            'General:read'
        ]
    ],
    denormalizationContext: [
        'groups' => [
            'Identifiant:read',
            'Evaluation:write'
        ]
    ],
    operations: [
        new Post(
            uriTemplate: '/gold-evaluation',
            stateless: false,
            security: "is_granted('ROLE_GAGE_EVALUATOR')",
        ),
        new Put(
            uriTemplate: '/gold-evaluation',
            requirements: ['id' => '\d+'],
            
        )
    ]
)]
class GoldEvaluation
{  
    #[Groups(['Attestation:read'])]
    public ?int $id = null;

    #[Groups(['Evaluation:write', 'Attestation:read'])]
    public int $clientFolio;

    /**
     * @var array<int, Gold>
     */
    #[Groups(['Evaluation:write', 'Attestation:read'])]
    public array $articles = [];

    #[Groups(['Evaluation:write', 'Attestation:read'])]
    public ?int $idCreditTypeTargeted = null;
    
    #[Groups(['Evaluation:write', 'Attestation:read'])]
    public ?string $description = null;

    #[Groups(['Attestation:read'])]
    public bool $canUpdateEvaluation = true;
}

