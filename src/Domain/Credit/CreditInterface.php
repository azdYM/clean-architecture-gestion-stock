<?php

namespace App\Domain\Credit;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Contract\ContractInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Entity\CreditApproval;
use App\Domain\Credit\Entity\CreditRejection;
use App\Domain\Mounting\Entity\CreditFolder;

interface CreditInterface
{
    public function getFolder(): CreditFolder;

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

    public function getCreditAgent(): Employee;
}