<?php

namespace App\Domain\Mounting\Exception;

class MountingFolderException extends \Exception
{
    public function __construct(?string $message = null)
    {
        $this->message = $message;        
    }
}