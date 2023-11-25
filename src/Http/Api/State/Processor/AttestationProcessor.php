<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Http\Api\DTO\Garantee\Attestation;

class AttestationProcessor implements ProcessorInterface
{
    public function __construct(
        EntityManagerInterface $em,
    ){}
    
    /**
     * Undocumented function
     *
     * @param Attestation $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        dd($data, $operation);
    }
}