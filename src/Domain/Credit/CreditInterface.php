<?php

namespace App\Domain\Credit;

use App\Domain\Customer\ClientInterface;
use Doctrine\Common\Collections\Collection;

interface CreditInterface
{
    public function getClient(): ?ClientInterface;

    /**
     * @return Collection<int, GaranteeInterface>
     */
    public function getGarantees(): Collection;

    /**
     * @return Collection<int, GaranteeInterface>
     */
    public function getContracts(): Collection;
    public function getCapital(): int;
    public function getInterest(): float;
    public function getStartedAt(): \DateTimeInterface;
    public function getEndAt(): \DateTimeInterface;
    public function getDuration(): int;
    public function getCode(): string;
}