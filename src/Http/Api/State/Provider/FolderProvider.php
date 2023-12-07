<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Credit\Folder;
use ApiPlatform\State\ProviderInterface;
use App\Http\Utils\MapClientEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Mounting\Entity\CreditFolder;
use App\Http\Utils\MapFolderEntityToDto;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Http\Utils\MapGaranteeAttestationEntityToDto;

class FolderProvider implements ProviderInterface
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
        $folder = $this->em->find(CreditFolder::class, $id);
        $dtoFolder = $this->mapFolderEntityToDto($folder);
        
        return $dtoFolder;
    }

    
}