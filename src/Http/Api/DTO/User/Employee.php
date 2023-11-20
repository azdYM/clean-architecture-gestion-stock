<?php

namespace App\Http\Api\DTO\User;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\ApiResource;
use App\Domain\Employee\Entity\Agency;
use App\Http\Api\State\Provider\MeProvider;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/me/employee',
            provider: MeProvider::class,
            normalizationContext: ['groups' => [
                'General:read',
                'CurrentUser:read',
            ]]
        )
    ]
)]
class Employee 
{
    #[Groups(['CurrentUser:read'])]
    public ?string $id = null;

    #[Groups(['CurrentUser:read'])]
    public ?string $email = null;

    #[Groups(['CurrentUser:read'])]
    public ?string $username = null;

    #[Groups(['CurrentUser:read'])]
    public ?string $fullname = null;

    #[Groups(['CurrentUser:read'])]
    public array $roles = [];

    #[Groups(['CurrentUser:read'])]
    public ?Agency $agency = null;

    #[Groups(['CurrentUser:read'])]
    public ?string $workingService = null;
}