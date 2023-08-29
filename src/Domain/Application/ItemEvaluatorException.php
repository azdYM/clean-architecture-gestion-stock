<?php

namespace App\Domain\Application;

class ItemEvaluatorException extends \Exception
{
    public function __construct(\Throwable $th, ?string $message = null)
    {
        $this->message = $message . ' - Error - ' . $th->getMessage();
    }
}