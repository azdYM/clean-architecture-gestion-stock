<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\Entity\AttestationRejection;

trait RejectionTrait
{
    #[ORM\OneToMany(targetEntity: AttestationRejection::class, mappedBy: 'attestation')]
    private Collection $rejections;

    public function getRejections(): Collection
    {
        return $this->rejections;
    }

    public function addRejection(AttestationRejection $rejection): static
    {
        if (!$this->rejections->contains($rejection)) {
            $this->rejections->add($rejection);
        }

        return $this;
    }

    public function remiveRejection(AttestationRejection $rejection): static
    {
        if ($this->rejections->contains($rejection)) {
            $this->rejections->removeElement($rejection);
        }

        return $this;
    }
}