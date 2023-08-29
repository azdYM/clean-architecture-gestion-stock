<?php

namespace App\Domain\Contract;

use App\Domain\Credit\CreditInterface;
use App\Domain\Contract\Components\Article;
use Doctrine\Common\Collections\Collection;
use App\Domain\Contract\Components\GeneralContent;
use App\Domain\Contract\Components\SignatureLabel;

interface ContractInterface
{    
    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection;
    
    /**
     * @return Collection<int, SignatureLabel>
     */
    public function getLabelsForSignature(): Collection;
    
    public function getGeneralContent(): GeneralContent;
}