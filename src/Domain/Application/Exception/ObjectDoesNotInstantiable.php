<?php

namespace App\Domain\Application\Exception;

class ObjectDoesNotInstantiable extends \ReflectionException
{
    public function __construct(?string $message = null)
    {
        $this->message = $message;
    }
}