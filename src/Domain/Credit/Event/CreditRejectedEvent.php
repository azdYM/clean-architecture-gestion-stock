<?php

namespace App\Domain\Credit\Event;

use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\Entity\CreditRejection;

class CreditRejectedEvent
{
    public function __construct(private CreditRejection $rejection)
    {}

    public function getCredit(): CreditInterface
    {
        return $this->rejection->getCredit();
    }
}