<?php

namespace App\Http\Utils;

use App\Domain\Mounting\Entity\CreditFolder;
use App\Http\Api\DTO\Credit\Folder;


trait MapFolderEntityToDto {

    use MapClientEntityToDto;
    use MapGaranteeAttestationEntityToDto;

    private function mapFolderEntityToDto(CreditFolder $folder): Folder
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