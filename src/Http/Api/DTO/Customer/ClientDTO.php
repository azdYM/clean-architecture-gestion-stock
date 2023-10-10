<?php

namespace App\Http\Api\DTO\Customer;

class ClientDTO
{
    public ?int $id;

    public ?int $folio;

    public array $locations = [];

    public array $contacts = [];
}