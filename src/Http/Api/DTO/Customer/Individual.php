<?php

namespace App\Http\Api\DTO\Customer;

use ApiPlatform\Metadata\ApiResource;
use App\Http\Api\DTO\Customer\ClientDTO;

#[ApiResource(
    
)]
final class Individual extends ClientDTO
{
    public ?string $nickname = null;

    public ?string $gender = null;

    public ?string $name = null;
}