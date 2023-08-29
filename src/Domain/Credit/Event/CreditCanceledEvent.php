<?php

namespace App\Domain\Credit;

use App\Domain\Application\CancellableInterface;

class CreditCanceledEvent
{
    public function __construct(private CreditInterface $credit)
    {}

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }
}