<?php

namespace App\Domain\Contract\Entity;

use App\Domain\Contract\Components\Article;
use Doctrine\Common\Collections\Collection;
use App\Domain\Contract\MakerArticlesInterface;

trait ArticleTrait
{
    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function generateAndSetArticles(MakerArticlesInterface $creator): static
    {
        $articles = $creator
            ->setContractType(get_called_class())
            ->generate()
        ;
        
        foreach($articles as $article) {
            $this->addArticle($article);
        }

        return $this;
    }

    private function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

}