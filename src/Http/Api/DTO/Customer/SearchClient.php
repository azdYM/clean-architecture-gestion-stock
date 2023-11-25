<?php

namespace App\Http\Api\DTO\Customer;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\State\Provider\SearchClientStateProvider;

#[ApiResource(
    operations: [
        new Get(
            provider: SearchClientStateProvider::class,
            uriTemplate: '/search-client/{folio}',
        ),
    ]
)]
class SearchClient 
{
    public ?int $folio = null;

    public ?string $clientType = null;

    public ?Client $client = null; 

    public ?bool $persisted = true;
}