<?php

namespace App\Domain\Application;

use Doctrine\Common\Collections\Collection;

interface MultipleContractGenerated
{
    /**
     * @return Collection<int, ContractInterface>
     */
    public function generateMultipleContract(MultipleContractGenerator $generator): void;
    public function getContracts(): Collection;
}