<?php

namespace App\Domain\Application;

use App\Domain\Credit\ArticleInterface;
use Doctrine\Common\Collections\Collection;

interface ArticleCreator
{
    public function setContractType(string $type): self;

    /**
     * @return Collection<int, ArticleInterface>
     */
    public function create(): Collection;
}