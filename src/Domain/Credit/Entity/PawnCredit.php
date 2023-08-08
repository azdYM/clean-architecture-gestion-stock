<?php

namespace App\Domain\Credit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use App\Domain\Mounting\Entity\Folder;
use App\Domain\Credit\ContractInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Entity\Contract\Contract;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\MultipleContractGenerated;
use App\Domain\Application\MultipleContractGenerator;
use App\Domain\Credit\Repository\PawnCreditRepository;

#[Entity(repositoryClass: PawnCreditRepository::class)]
class PawnCredit extends ShortTermCredit implements MultipleContractGenerated
{
    #[ORM\OneToOne(targetEntity: Folder::class, mappedBy: 'credit')]
    protected ?FolderInterface $folder = null;

    #[ORM\JoinTable(name: 'credits_renawal_credits')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn('renawal_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: RenawalCredit::class)]
    private Collection $renawals;

    /**
     * @var Collection<int, ContractInterface>
     */
    #[ORM\JoinTable(name: 'contracts_credits')]
    #[ORM\JoinColumn(name: 'credit_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity:Contract::class)]
    protected Collection $contracts;

    public function __construct()
    {
        parent::__construct();
        $this->createdAt = new \DateTimeImmutable();
        $this->renawals = new ArrayCollection();
        $this->contracts = new ArrayCollection();
    }

    /**
     * @return Collection<int, ContractInterface>
     */
    public function getContracts(): Collection
    {
        return $this->contracts;
    }

    public function addContract(ContractInterface $contract): self
    {
        if (!$this->contracts->contains($contract)) {
            $this->contracts->add($contract);
        }

        return $this;
    }

    public function generateMultipleContract(MultipleContractGenerator $generator): void
    {
        
    }

    public function getRenawalCredits(): Collection
    {
        return $this->renawals;
    }

    public function addRenawalCredit(PawnCredit $renawal): self
    {
        if (!$this->renawals->contains($renawal)) {
            $this->renawals = $renawal;
        }

        return $this;
    }
}