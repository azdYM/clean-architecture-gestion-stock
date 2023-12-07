<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Credit\Entity\Credit;
use App\Http\Utils\MapClientEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Api\DTO\Credit\Credit as CreditDto;
use App\Http\Utils\MapFolderEntityToDto;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Http\Utils\MapGaranteeAttestationEntityToDto;

class CreditProvider implements ProviderInterface
{
    use MapFolderEntityToDto;
    
    public function __construct
    (
        private EntityManagerInterface $em,
        private WorkflowInterface $attestationGage,

    ){}
    
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        
        $id = $uriVariables['id'];
        /** @var Credit */
        $credit = $this->em->find(Credit::class, $id);
        $dtoCredit = $this->mapEntityToDto($credit);
        
        return $dtoCredit;
    }

    private function mapEntityToDto(Credit $credit): CreditDto 
    {
        $dtoCredit = new CreditDto();
        $dtoCredit->id = $credit->getId();
        $dtoCredit->folder = $this->mapFolderEntityToDto($credit->getFolder());
        $dtoCredit->contracts = $credit->getContracts()->toArray();
        $dtoCredit->updatedAt = $credit->getUpdatedAt();

        return $dtoCredit;
    }
}