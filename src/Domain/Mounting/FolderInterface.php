<?php

namespace App\Domain\Mounting;

use App\Domain\Credit\CreditInterface;
use App\Domain\Customer\ClientInterface;
use Doctrine\Common\Collections\Collection;

interface FolderInterface
{
    public function getClient(): ?ClientInterface;
    
    /**
     * @return Collection<int, GaranteeInterface>
     */
    public function getGarantees(): Collection;

    public function getCredit(): ?CreditInterface;

    public function getState(): ?string;

    public function setState(string $state): self;
}