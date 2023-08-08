<?php

namespace App\Domain\Credit\Entity\Contract;

use Doctrine\Common\Collections\Collection;

trait TraitContract
{
    /**
     * @param Collection<int, ArticleInterface> $articles
     */
    protected function addArticles(Collection $articles): void
    {
        foreach($articles as $article) {
            if (!$this->articles->contains($article)) {
                $this->articles->add($article);
            }
        }
    }
}