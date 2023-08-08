<?php

namespace App\Domain\Credit\Entity\Contract;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Application\ArticleCreator;
use App\Domain\Application\ContentCreatorInterface;
use App\Domain\Application\LabelContainSignatureCreator;
use App\Domain\Credit\Repository\Contract\ContractGageRepository;

#[ORM\Entity(repositoryClass: ContractGageRepository::class)]
class DeathSolidarity extends Contract
{
    use TraitContract;

    public function createAndSetGeneralContent(ContentCreatorInterface $creator): self
    {
        return $this;
    }

    public function createAndSetArticles(ArticleCreator $creator): self
    {
        $articles = $creator
            ->setContractType(DeathSolidarity::class)
            ->create()
        ;

        $this->addArticles($articles);
        return $this;
    }

    public function createAndSetLabelsContainSignature(LabelContainSignatureCreator $creator): self
    {
        return $this;
    }
}