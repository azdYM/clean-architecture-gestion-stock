<?php

namespace App\Domain\Mounting\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditRejection;
use Doctrine\Common\Collections\Collection;

trait RejectionTrait
{
    #[ORM\OneToMany(targetEntity: CreditRejection::class, mappedBy: 'credit')]
    protected Collection $rejections;

    public function getRejections(): Collection
    {
        return $this->rejections;
    }

    private function addRejection(CreditRejection $rejection): self
    {
        if (!$this->rejections->contains($rejection)) {
            $this->rejections->add($rejection);
        }

        return $this;
    }
}