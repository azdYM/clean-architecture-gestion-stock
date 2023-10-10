<?php

namespace App\Http\Api\DTO\Customer;

use ApiPlatform\Metadata\ApiResource;
use App\Domain\Application\Entity\IdentifiableTrait;

#[ApiResource]
class Contact 
{
    use IdentifiableTrait;
    
}