<?php

namespace App\Domain\Contract;

use App\Domain\Contract\Components\Article;
use App\Domain\Contract\Entity\Contract;
use Doctrine\Common\Collections\Collection;

interface MakerArticlesInterface
{
    public function setContract(Contract $type): self;

    public function generate(): array;
}