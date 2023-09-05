<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\ContractInterface;
use App\Domain\Contract\Entity\GageContract;
use App\Domain\Contract\CompositionInterface;
use App\Domain\Application\Entity\TimestampTrait;
use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Contract\Entity\DeathSolidarityContract;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap([
    'contract' => Contract::class,
    'gage' => GageContract::class, 
    'death_solidarity' => DeathSolidarityContract::class]
)]
abstract class Contract implements ContractInterface, CompositionInterface
{
    use IdentifiableTrait;
    use TimestampTrait;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }
}