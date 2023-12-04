<?php

namespace App\Domain\Garantee\DTO;

use App\Domain\Garantee\ItemInterface;
use App\Domain\Credit\Entity\CreditType;
use App\Domain\Customer\ClientInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

class Garantee 
{
    /** @var Collection<int, ItemInterface> $articles*/
    public Collection $articles;

    public ClientInterface $client;

    public ?string $description = null;

    public ?CreditType $creditTypeTargeted = null;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    /** @return Collection<int, ItemInterface> */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(ItemInterface $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function getClient(): ClientInterface
    {
        return $this->client;
    }

    public function setClient(ClientInterface $client): self
    {
        $this->client = $client;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreditTypeTargeted(): CreditType
    {
        return $this->creditTypeTargeted;
    }

    public function setCreditTypeTargeted(CreditType $creditType): self
    {
        $this->creditTypeTargeted = $creditType;
        return $this;
    }
}