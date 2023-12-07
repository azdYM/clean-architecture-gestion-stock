<?php

namespace App\Domain\Contract\Entity;

use App\Domain\Contract\MakerArticlesInterface;

trait ArticleTrait
{
    public function getArticles(): array
    {
        return $this->articles;
    }

    public function generateAndSetArticles(MakerArticlesInterface $creator): static
    {
        $articles = $creator
            ->setContract($this)
            ->generate()
        ;
        
        foreach($articles as $article) {
            $this->addArticle($article);
        }

        return $this;
    }

    /**
     * Ajoute l'article qui devrait contenir un title et description
     * je devrai dabord checker si article contient bien ces valeurs et levé une exception
     * dans le cas contraire, mais je suis fatigué et épuisé, je verrai plus tard
     *
     * @param array $article
     * @return self
     */
    private function addArticle(array $article): self
    {
        $this->articles[] = $article;
        return $this;
    }

}