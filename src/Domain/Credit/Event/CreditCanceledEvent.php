<?php

namespace App\Domain\Credit\Event;

use App\Domain\Credit\CreditInterface;

class CreditCanceledEvent
{
    public function __construct(private CreditInterface $credit)
    {}

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }
}