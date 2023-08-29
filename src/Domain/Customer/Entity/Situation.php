<?php

namespace App\Domain\Customer\Entity;

use App\Domain\Application\Entity\IdentifiableTrait;
use App\Domain\Application\Entity\TimestampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class Situation 
{
    use IdentifiableTrait;
    use TimestampTrait;

    #[ORM\ManyToOne(targetEntity: MatrimonialStatus::class, inversedBy: 'situations')]
    #[ORM\JoinColumn(name: 'matrimonial_status_id', referencedColumnName: 'id')]
    protected ?MatrimonialStatus $matrimonialStatus = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getMatrimonialStatus(): MatrimonialStatus
    {
        return $this->matrimonialStatus;
    }

    public function setMatrimonialStatus(MatrimonialStatus $matrimonialStatus): self
    {
        $this->matrimonialStatus = $matrimonialStatus;
        return $this;
    }
}