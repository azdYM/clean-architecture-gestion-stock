<?php

namespace App\Domain\Mounting;

use App\Domain\Credit\CreditInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;

interface FolderInterface
{
    public function getPortfolio(): ?Portfolio;
    public function getCredit(): ?CreditInterface;
    public function setCredit(CreditInterface $credit): self;
    public function getState(): ?string;
    /**
     * @return Collection<int, Attestation>
     */
    public function getAttestations(): Collection;
    
}