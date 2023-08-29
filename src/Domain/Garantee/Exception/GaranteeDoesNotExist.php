<?php

namespace App\Domain\Garantee\Exception;

class GaranteeDoesNotExist extends \Exception
{
    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }
}