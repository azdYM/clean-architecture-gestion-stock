<?php

namespace App\Domain\Garantee;

use App\Domain\Credit\Entity\CreditType;
use App\Domain\Customer\ClientInterface;
use App\Domain\Employee\Entity\Employee;
use Doctrine\Common\Collections\Collection;

interface AttestationInterface
{
    /** 
     * @return Collection<int, ItemInterface> 
     * */
    public function getItems(): Collection;
    public function addItem(ItemInterface $item): self;
    public function getValorisation(): int;
    public function getClient(): ClientInterface;
    public function getCreditTypeTargeted(): ?CreditType;
    public function getEvaluator(): Employee;
}