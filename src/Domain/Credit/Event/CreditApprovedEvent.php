<?php

namespace App\Domain\Credit;

use App\Domain\Mounting\Entity\CreditAgent;

class CreditApprovedEvent
{
    public function __construct(
        private CreditInterface $credit
    ){}

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function getCreditAgent(): CreditAgent
    {
        return $this->credit
            ->getCreditAgent()
        ;
    }
}