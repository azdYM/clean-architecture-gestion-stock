<?php

namespace App\Domain\Credit\Entity\Contract;

use App\Domain\Credit\ArticleInterface;
use App\Domain\Credit\Credit;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Credit\CreditInterface;
use App\Domain\Credit\Entity\Signature;
use App\Domain\Credit\ContractInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Credit\Entity\Contract\ComposantsInterface;
use App\Domain\Credit\Repository\Contract\ContractRepository;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'discr', type: 'string')]
#[ORM\DiscriminatorMap([
    'contract' => Contract::class, 
    'gage' => Gage::class,
    'death_solidarity' => DeathSolidarity::class
])]
abstract class Contract implements ContractInterface, ComposantsInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    protected ?int $id = null;

    #[ORM\OneToOne(targetEntity: Credit::class)]
    protected CreditInterface $credit;

    #[ORM\OneToOne(targetEntity: GeneralContent::class, inversedBy: 'contract')]
    #[ORM\JoinColumn(name: 'content_id', referencedColumnName: 'id')]
    protected ?GeneralContent $content = null;

    #[ORM\JoinTable(name: 'contracts_signatures')]
    #[ORM\JoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'signature_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Signature::class)]
    protected Collection $labelsContainSignature;

    #[ORM\JoinTable(name: 'articles_contracts')]
    #[ORM\JoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'article_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Article::class)]
    protected Collection $articles; 

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->labelsContainSignature = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCredit(): CreditInterface
    {
        return $this->credit;
    }

    public function setCredit(CreditInterface $credit)
    {
        $this->credit = $credit;
    }

    public function getGeneralContent(): GeneralContent
    {
        return $this->content;
    }

    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(ArticleInterface $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->add($article);
        }

        return $this;
    }

    public function getLabelsContainSignature(): Collection
    {
        return $this->labelsContainSignature;
    }
}