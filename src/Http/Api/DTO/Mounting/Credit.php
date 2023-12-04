<?php

namespace App\Http\Api\DTO\Mounting;

use DateTimeInterface;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
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
        )
    ]
)]
class Credit 
{
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

    #[Groups(['Credit:read'])]
    public ?DateTimeInterface $updatedAt = null;
}