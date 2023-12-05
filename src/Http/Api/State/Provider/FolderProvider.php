<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Mounting\Folder;
use ApiPlatform\State\ProviderInterface;
use App\Http\Utils\MapClientEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Mounting\Entity\CreditFolder;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Http\Utils\MapGaranteeAttestationEntityToDto;

class FolderProvider implements ProviderInterface
{
    use MapClientEntityToDto;
    use MapGaranteeAttestationEntityToDto;

    public function __construct
    (
        private EntityManagerInterface $em,
        private WorkflowInterface $attestationGage,

    ){}
    
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        
        $id = $uriVariables['id'];
        $folder = $this->em->find(CreditFolder::class, $id);
        $dtoFolder = $this->mapEntityToDto($folder);
        
        return $dtoFolder;
    }

    private function mapEntityToDto(CreditFolder $folder): Folder 
    {
        $dtoFolder = new Folder();
        $dtoFolder->id = $folder->getId();
        $dtoFolder->client = $this->mapClientEntityToDto(
            $folder->getPortfolio()->getClient()
        );

        $dtoAttestations = [];
        $attestations = $folder->getAttestations()->toArray();
        $this->addCollectionAttestationsToDto($attestations, $dtoAttestations);
        
        $dtoFolder->attestations = $dtoAttestations;
        $dtoFolder->updatedAt = $folder->getUpdatedAt();

        return $dtoFolder;
    }
}