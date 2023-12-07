<?php

namespace App\Http\Api\DTO\Credit;

use DateTimeInterface;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\Client;
use App\Http\Api\DTO\Garantee\Attestation;
use App\Http\Api\State\Provider\FolderProvider;
use App\Http\Api\State\Processor\FolderProcessor;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => [
        'Folder:read',
        'General:read',
        'Client:read',
        'Location:read',
        'Contact:read'
    ]],
    operations: [
        new Post(
            uriTemplate: '/folder/create',
            stateless: false,
            processor: FolderProcessor::class,
            denormalizationContext: ['groups' => [
                'Folder:write'
            ]],
        ),
        new Get(
            uriTemplate: '/folder/{id}',
            provider: FolderProvider::class,
        )
    ]
)]
class Folder 
{
    #[Groups(['Folder:read'])]
    public int $id;

    #[Groups(['Folder:write'])]
    public ?int $clientFolio = null;

    #[Groups(['Folder:read'])]
    public ?Client $client = null;

    /**
     * @var array<int, Attestation>
     */
    #[Groups(['Folder:write', 'Folder:read'])]
    public array $attestations = [];

    #[Groups(['Folder:read'])]
    public ?DateTimeInterface $updatedAt = null;
}