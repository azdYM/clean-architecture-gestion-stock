<?php

namespace App\Domain\Application;

use Doctrine\Common\Collections\Collection;

interface MultipleContractGenerator 
{
    public function setContractType(string|array $type): self;
    /**
     * @return Collection<int, ContractInerface>
     */
    public function generate(): Collection;
}