<?php

namespace App\Http\Api\DTO\Customer;

use App\Domain\Customer\Entity\Contact;
use App\Domain\Customer\Entity\Location;
use Symfony\Component\Serializer\Annotation\Groups;

class Client
{
    #[Groups(['Attestations:read', 'Folder:read', 'Credits:read'])]
    public ?int $id;
    
    #[Groups(['Attestations:read', 'Folder:read', 'Credits:read'])]
    public ?string $name = null;

    #[Groups(['Attestations:read', 'Folder:read', 'Credits:read'])]
    public ?int $folio;

    /**
     * @var array<int, Location>
     */
    #[Groups(['Location:read'])]
    public array $locations = [];
    
    /**
     * @var array<int, Contact>
     */
    #[Groups(['Contact:read'])]
    public array $contacts = [];

    // ============ Individual ===============
    #[Groups(['Client:read'])]
    public ?string $nickname = null;

    #[Groups(['Client:read'])]
    public ?string $gender = null;

    #[Groups(['Client:read'])]
    public ?string $nin = null;

    #[Groups(['Client:read'])]
    public ?\DateTimeInterface $birthDay = null;

    #[Groups(['Location:read'])]
    public ?Location $birthLocation = null;

    // ================== Corporate ==============
    #[Groups(['Client:read'])]
    public ?string $legalForm = null;
    
    #[Groups(['Client:read'])]
    public ?string $activityDomain = null;

    #[Groups(['Client:read'])]
    public ?string $comericialRegistry = null;
}