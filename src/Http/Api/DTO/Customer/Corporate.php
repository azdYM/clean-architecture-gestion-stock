<?php

namespace App\Http\Api\DTO\Customer;

use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\ClientDTO;
use ApiPlatform\Doctrine\Odm\State\CollectionProvider;

#[ApiResource(
    provider: CollectionProvider::class
)]
class Corporate extends ClientDTO
{
    public ?string $name = null;

    public ?string $legalForm = null;
    
    public ?string $activityDomain = null;

    public ?string $comericialRegistry = null;
}