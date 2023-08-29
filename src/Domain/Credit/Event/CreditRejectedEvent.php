<?php

namespace App\Domain\Credit;

use App\Domain\Credit\CreditRejection;

class CreditRejectedEvent
{
    public function __construct(private CreditRejection $rejection)
    {}

    public function getCredit(): CreditInterface
    {
        return $this->rejection->getCredit();
    }
}