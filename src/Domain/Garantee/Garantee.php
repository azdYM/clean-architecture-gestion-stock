<?php

namespace App\Domain\Garantee;

use App\Domain\Credit\Credit;
use App\Domain\Credit\CreditInterface;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Mounting\Entity\Folder;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Customer\Repository\GaranteeRepository;

#[ORM\MappedSuperclass(repositoryClass: GaranteeRepository::class)]
abstract class Garantee implements GaranteeInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Credit::class, inversedBy: 'garantees')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    protected ?CreditInterface $credit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function setCredit(CreditInterface $credit): void
    {
        $this->credit = $credit;
    }
}