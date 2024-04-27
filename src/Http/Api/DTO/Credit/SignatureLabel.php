<?php

namespace App\Http\Api\DTO\Credit;

use Symfony\Component\Serializer\Annotation\Groups;

class SignatureLabel 
{
    #[Groups(['Contract:read'])]
    public ?string $label;
}