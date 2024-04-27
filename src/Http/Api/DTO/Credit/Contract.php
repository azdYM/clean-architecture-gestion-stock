<?php

namespace App\Http\Api\DTO\Credit;

use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\State\Processor\ContractProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => [
        'Contract:read',
        'General:read',
        
    ]],
    operations: [
        new Post(
            uriTemplate: '/contracts/generate',
            stateless: false,
            processor: ContractProcessor::class,
            denormalizationContext: ['groups' => [
                'Contract:write'
            ]]
        ),
    ]
)]
class Contract 
{
    #[Groups(['Contract:read'])]
    public ?int $id = null;

    #[Groups(['Contract:write'])]
    public ?int $creditId = null;

    #[Groups(['Contract:read'])]
    public ?string $content = null;
    
    /**
     * @var Article[] $articles
     */
    #[Groups(['Contract:read'])]
    public ?array $articles = [];

    /**
     * @var SignatureLabel[] $labelsForSignature
     */
    #[Groups(['Contract:read'])]
    public ?array $labelsForSignature = [];

    #[Groups(['Contract:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}