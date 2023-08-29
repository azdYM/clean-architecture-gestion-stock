<?php

namespace App\Domain\Contract;

use App\Domain\Contract\Components\Article;
use Doctrine\Common\Collections\Collection;

interface MakerArticlesInterface
{
    public function setContractType(string $type): self;

    /**
     * @return Collection<int, Article>
     */
    public function generate(): Collection;
}