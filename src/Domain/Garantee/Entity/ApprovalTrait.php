<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Employee;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\Entity\AttestationApproval;

trait ApprovalTrait
{
    #[ORM\OneToMany(targetEntity: AttestationApproval::class, mappedBy: 'attestation')]
    private Collection $approvals;

    public function getApprovals(): Collection
    {
        return $this->approvals;
    }

    public function addApproval(AttestationApproval $approval): static
    {
        if (!$this->approvals->contains($approval)) {
            $this->approvals->add($approval);
        }

        return $this;
    }

    public function removeApproval(AttestationApproval $approval): static
    {
        if ($this->approvals->contains($approval)) {
            $this->approvals->removeElement($approval);
        }

        return $this;
    }
}