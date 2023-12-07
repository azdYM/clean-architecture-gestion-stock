<?php

namespace App\Http\Api\DTO\Credit;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\Contract\Entity\Contract;
use App\Http\Api\State\Provider\CreditProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Processor\PawnCreditProcessor;

#[ApiResource(
    normalizationContext: ['groups' => [
        'Credit:read',
        'General:read',
        
    ]],
    operations: [
        new Post(
            uriTemplate: '/pawn-credit/create',
            stateless: false,
            processor: PawnCreditProcessor::class,
            denormalizationContext: ['groups' => [
                'Credit:write'
            ]],
        ),
        new Get(
            uriTemplate: '/credit/{id}',
            provider: CreditProvider::class
        )
    ]
)]
class Credit 
{
    /**
     * Identifiant du crédit
     *
     * @var integer
     */
    #[Groups(['Credit:read'])]
    public int $id;

    #[Groups(['Credit:write'])]
    public ?int $folderId = null;

    #[Groups(['Credit:write'])]
    public int $capital;

    #[Groups(['Credit:write'])]
    public int $duration;

    #[Groups(['Credit:read'])]
    public ?Folder $folder = null;

    /**
     *
     * @var array<int Contract>
     */
    #[Groups(['Credit:read'])]
    public ?array $contracts = [];

    #[Groups(['Credit:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}