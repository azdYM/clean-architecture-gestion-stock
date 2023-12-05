<?php

namespace App\Http\Utils;

use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\Entity\ShortTerm\GageFolder;
use App\Domain\Mounting\Repository\ShortTerm\GageFolderRepository;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ObtainFolderTrait {

    public function getFolder(int $id): FolderInterface|null
    {
        if (empty($id)) {
            throw new NotFoundResourceException(
                "Aucun id n'a été saisit ! Veuillez s'il vous plait saisir un id"
            );
        }
        
        $repository = $this->getFolderRepository(GageFolder::class);
        $folder = $repository->find($id);
        
        if ($folder === null) {
            // on peut apeller d'autre type de dossier repository, 
            // a implémenter plus tard.
            // d'ailleur je dois eviter d'utiliser l'identifiant 
        }
        
        return $folder;
    }

    public function getFolderRepository(string $className): GageFolderRepository
    {
        return $this->em->getRepository($className);
    }
}