<?php

namespace App\Domain\Mounting;

use App\Domain\Credit\CreditInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Garantee\Entity\GaranteeAttestation;

interface FolderInterface
{
    public function getPortfolio(): ?Portfolio;
    public function getCredit(): ?CreditInterface;
    public function setCredit(CreditInterface $credit): self;
    public function getState(): ?string;
    
    /**
     * @return Collection<int, GaranteeAttestation>
     */
    public function getAttestations(): Collection;
    
}