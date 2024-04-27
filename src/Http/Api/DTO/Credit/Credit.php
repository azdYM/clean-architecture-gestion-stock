<?php

namespace App\Http\Api\DTO\Credit;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Credit\Contract;
use ApiPlatform\Metadata\GetCollection;
use App\Domain\Employee\Entity\Employee;
use App\Http\Api\State\Provider\CreditProvider;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Http\Api\State\Processor\PawnCreditProcessor;

#[ApiResource(
    
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
            provider: CreditProvider::class,
            normalizationContext: ['groups' => [
                'Credits:read', 
                'Credit:read',
                'Folder:read',
                'Contract:read',
                'General:read',
                'CurrentUser:read'
            ]],
        ),
        new GetCollection(
            uriTemplate: '/credits',
            provider: CreditProvider::class,
            normalizationContext: [
                'groups' => [
                    'General:read',
                    'Credits:read', 
                ]
            ]  
        ),
    ]
)]
class Credit 
{
    #[Groups(['Credit:read', 'Credits:read'])]
    public int $id;

    #[Groups(['Credit:write'])]
    public ?int $folderId = null;

    #[Groups(['Credit:write', 'Credits:read'])]
    public int $capital;

    #[Groups(['Credit:write', 'Credit:read'])]
    public int $duration;

    #[Groups(['Credit:read'])]
    public ?int $idADBankingFolder = null;

    #[Groups(['Credit:read'])]
    public ?string $code = null;

    #[Groups(['Credits:read'])]
    public ?string $currentPlace = null;

    #[Groups(['Credit:read'])]
    public ?\DateTimeInterface $startedAt = null;

    #[Groups(['Credit:read'])]
    public ?\DateTimeInterface $endAt = null;

    #[Groups(['Credit:read'])]
    public ?float $interest = null;

    #[Groups(['Folder:read', 'Credits:read'])]
    public ?Folder $folder = null;

    #[Groups(['CurrentUser:read'])]
    public ?Employee $creditAgent = null;

    /**
     * @var array<int, Contract>
     */
    #[Groups(['Contract:read'])]
    public ?array $contracts = [];

    #[Groups(['Credits:read'])]
    public ?\DateTimeInterface $updatedAt = null;
}