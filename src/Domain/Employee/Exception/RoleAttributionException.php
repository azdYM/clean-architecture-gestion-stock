<?php

namespace App\Domain\Employee\Exception;

class RoleAttributionException extends \Exception
{
    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }
}