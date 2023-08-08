<?php

namespace App\Domain\Credit\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\ArticleInterface;
use App\Domain\Credit\Entity\Contract\Article;
use App\Domain\Credit\Entity\Contract\GeneralContent;
use App\Domain\Credit\Repository\ParameterInDescriptionRepository;

#[ORM\Entity(repositoryClass: ParameterInDescriptionRepository::class)]
class ParameterInDescription 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $position = null;

    #[ORM\Column]
    private ?string $key = null;

    #[ORM\Column]
    private ?string $value = null;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'parametersInDescription')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id')]
    private ?ArticleInterface $article = null;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'parametersInDescription')]
    #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id')]
    private ?GeneralContent $content = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;
        return $this;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;
        return $this;
    }

    public function getArticle(): ArticleInterface
    {
        return $this->article;
    }

    public function setArtcile(ArticleInterface $article): self
    {
        $this->article = $article;
        return $this;
    }

    public function getGeneralContent(): GeneralContent
    {
        return $this->content;
    }

    public function setGeneralContent(GeneralContent $content): self
    {
        $this->content = $content;
        return $this;
    }
}