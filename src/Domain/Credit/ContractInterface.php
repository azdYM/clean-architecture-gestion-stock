<?php

namespace App\Domain\Credit;

use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Entity\Contract\GeneralContent;

interface ContractInterface
{
    public function getCredit(): CreditInterface;
    
    /**
     * @return Collection<int, ArticleInterface>
     */
    public function getArticles(): Collection;
    
    /**
     * @return Collection<int, SignatureInterface>
     */
    public function getLabelsContainSignature(): Collection;
    public function getGeneralContent(): GeneralContent;
}