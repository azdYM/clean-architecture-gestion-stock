<?php

namespace App\Domain\Contract\Components;

use App\Domain\Application\Entity\IdentifiableTrait;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\Components\ArticleRepository;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    use ContractTypeTrait;
    use IdentifiableTrait;
    
    #[ORM\Column]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getContractType(): string 
    {
        return $this->contractType;
    }

    public function setContractType(string $contractClass): self
    {
        $this->contractType = $contractClass;
        return $this;
    }

    public function setArticle(string $title, string $description): self
    {
        $this->title = $title;
        $this->description = $description;
        return $this;
    }
}