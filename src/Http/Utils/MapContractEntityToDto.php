<?php

namespace App\Http\Utils;

use App\Domain\Contract\Entity\Contract;
use App\Http\Api\DTO\Credit\Contract as ConctractDTO;


trait MapContractEntityToDto {

    private function mapContractToDto(Contract $contract): ConctractDTO
    {
        $contractDto = new ConctractDTO();
        $contractDto->id = $contract->getId();
        $contractDto->content = $contract->getContent(); 
        $contractDto->updatedAt = $contract->getUpdatedAt();

        $dtoArticles = [];
        $dtoSignatureForLabels = [];

        foreach($contract->getArticles() as $key => $article) {
            $dtoArticles[$key] = $article;
        }

        foreach($contract->getLabelsForSignature() as $key => $label) {
            $dtoSignatureForLabels[$key] = $label;
        }

        $contractDto->articles = $dtoArticles;
        $contractDto->labelsForSignature = $dtoSignatureForLabels;
        
        return $contractDto;
    }

    
}