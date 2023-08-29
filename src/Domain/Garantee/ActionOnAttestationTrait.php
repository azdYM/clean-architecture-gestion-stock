<?php

namespace App\Domain\Garantee;

use App\Domain\Employee\Employee;
use App\Domain\Application\CancellableInterface;
use App\Domain\Garantee\Entity\AttestationApproval;
use App\Domain\Garantee\Entity\AttestationRejection;

trait ActionOnAttestationTrait
{
    public function approved(Employee $supervisor, ?string $comment): AttestationApproval
    {
        return (new AttestationApproval)
            ->setApproving($supervisor)
            ->setAttestation($this)
            ->setComment($comment)
        ;
    }

    public function rejected(Employee $supervisor, ?string $cause): AttestationRejection
    {
        return (new AttestationRejection)
            ->setAttestation($this)
            ->setCause($cause)
            ->setSupervisor($supervisor)
        ;
    }

    public function canceled(Employee $supervisor, string $cause): bool|\Throwable
    {
        if (!$this instanceof CancellableInterface) {
            throw new \Exception(sprintf(
                "L'objet %s n'es pas une instace de %s :) Pensez à implementer cette classe à cette interface", 
                get_called_class(), 
                CancellableInterface::class
            ));
        }

        $this
            ->setCancellationCause($cause)
            ->setCancelledAt(new \DateTimeImmutable())
            ->setCancelledBy($supervisor)
        ;

        return true;
    }
}