<?php

namespace App\Domain\Mounting;

use App\Domain\Application\CancellableInterface;
use App\Domain\Credit\CreditApproval;
use App\Domain\Credit\CreditRejection;
use App\Domain\Employee\Employee;

trait ActionOnCreditTrait
{    
    public function approved(Employee $supervisor, ?string $comment = null): CreditApproval
    {
        $approval = (new CreditApproval)
            ->setCredit($this)
            ->setApproving($supervisor)
            ->setComment($comment)
        ;

        $this->addApproval($approval);
        return $approval;
    }

    public function rejected(Employee $supervisor, string $cause): CreditRejection
    {
        $rejection = (new CreditRejection)
            ->setCredit($this)
            ->setApproving($supervisor)
            ->setCause($cause)
        ;

        $this->addRejection($rejection);
        return $rejection;
    }

    public function canceled(Employee $supervisor, string $cause): bool|\Throwable
    {
        if (!$this instanceof CancellableInterface) {
            throw new \Exception(sprintf(
                "L'objet %s n'es pas une instace de %s :) Pensez à implementer cette classe à cette interface", 
                get_called_class($this), 
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