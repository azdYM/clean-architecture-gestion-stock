<?php

namespace App\Http\Api\DTO\Credit;

use Symfony\Component\Serializer\Annotation\Groups;

class Article 
{
    #[Groups(['Contract:read'])]
    public ?string $title;

    #[Groups(['Contract:read'])]
    public ?string $description;
}