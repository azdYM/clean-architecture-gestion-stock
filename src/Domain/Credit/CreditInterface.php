<?php

namespace App\Domain\Credit;

use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditRejection;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Mounting\FolderInterface;
use App\Domain\Contract\ContractInterface;
use App\Domain\Mounting\Entity\CreditAgent;
use Doctrine\Common\Collections\Collection;

interface CreditInterface
{
    public function getFolder(): FolderInterface;

    /**
     * @return Collection<int, ContractInterface>
     */
    public function getContracts(): Collection;

    /**
     * @return Collection<int, CreditApproval>
     */
    public function getApprovals(): Collection;

    /**
     * @return Collection<int, CreditRejection>
     */
    public function getRejections(): Collection;

    public function approved(Employee $supervisor, ?string $comment = null): CreditApproval;

    public function rejected(Employee $supervisor, string $cause): CreditRejection;

    public function getCreditAgent(): CreditAgent;
}