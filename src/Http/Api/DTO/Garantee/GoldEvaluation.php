<?php

namespace App\Http\Api\DTO\Garantee;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Patch;
use App\Domain\Garantee\Entity\Gold\Gold;
use App\Domain\Garantee\Entity\Attestation;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Processor\GoldEvaluationStateProcessor;

#[ApiResource(
    processor: GoldEvaluationStateProcessor::class,
    operations: [
        new Post(
            uriTemplate: '/gold-evaluation',
            stateless: false,
            security: "is_granted('ROLE_GAGE_EVALUATOR')",
            normalizationContext: ['groups' => [
                'GoldEvaluation:read', 'Attestation:read', 'General:read'
            ]]
        ),
        new Put(
            uriTemplate: '/gold-evaluation',
            requirements: ['id' => '\d+'],
            denormalizationContext: [
                'groups' => [
                    'Identifiant:read',
                    'Evaluation:write'
                ]
            ]
        )
    ]
)]
class GoldEvaluation
{  
    public ?int $id = null;

    public int $clientFolio;

    /**
     * @var array<int, Gold>
     */
    #[Groups(['Evaluation:write'])]
    public array $articles = [];

    #[Groups(['Evaluation:write'])]
    public ?int $idCreditTypeTargeted = null;
    
    #[Groups(['Evaluation:write'])]
    public ?string $description = null;

    public bool $canUpdateEvaluation = true;
}

