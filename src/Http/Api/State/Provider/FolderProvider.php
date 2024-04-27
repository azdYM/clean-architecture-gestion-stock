<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Credit\Folder;
use ApiPlatform\State\ProviderInterface;
use App\Http\Utils\MapClientEntityToDto;
use App\Http\Utils\MapFolderEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Mounting\Entity\CreditFolder;
use Symfony\Component\Workflow\WorkflowInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

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
        if ($folder === null) {
            throw new NotFoundResourceException(sprintf(
                'Impossible de trouver le dossier %s', $id
            ));
        }
        $dtoFolder = $this->mapFolderEntityToDto($folder);
        
        return $dtoFolder;
    }

    
}