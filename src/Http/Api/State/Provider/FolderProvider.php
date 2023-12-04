<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Domain\Mounting\Entity\GageFolder;
use Doctrine\ORM\EntityManagerInterface;

class FolderProvider implements ProviderInterface
{
    public function __construct
    (
        private EntityManagerInterface $em
    ){}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        
        $id = $uriVariables['id'];
        $folder = $this->em->getRepository(GageFolder::class)->findFolderWithAttestations($id);
        dd($folder, $id);
    }
}