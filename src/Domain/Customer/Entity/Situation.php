<?php

namespace App\Domain\Customer\Entity;

use App\Domain\Customer\Repository\SituationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass(repositoryClass: SituationRepository::class)]
abstract class Situation 
{
    #[ORM\Id]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    protected \DateTimeInterface $updatedAt;
    
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

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}