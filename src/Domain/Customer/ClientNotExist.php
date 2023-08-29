<?php

namespace App\Domain\Customer;

class ClientNotExist extends \Exception
{
    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }
}