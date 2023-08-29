<?php

namespace App\Domain\Credit\Exception;

class CreditNotFoundException extends \Exception
{
    public function __construct()
    {
        $this->message = "Impossible de trouver ce crédit :)";
    }
}