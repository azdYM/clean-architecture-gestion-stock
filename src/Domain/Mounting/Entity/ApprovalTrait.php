<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditApproval;
use Doctrine\Common\Collections\Collection;

trait ApprovalTrait
{
    #[ORM\OneToMany(targetEntity: CreditApproval::class, mappedBy: 'credit')]
    protected Collection $approvals;

    public function getApprovals(): Collection
    {
        return $this->approvals;
    }

    private function addApproval(CreditApproval $approval): self
    {
        if (!$this->approvals->contains($approval)) {
            $this->approvals->add($approval);
        }

        return $this;
    }
}