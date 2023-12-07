<?php

namespace App\Infrastructure\Generator\Contract;

use DateTime;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Contract\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\Contract\Components\Article;
use App\Domain\Contract\MakerArticlesInterface;
use Symfony\Component\Validator\Constraints\Date;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use App\Domain\Contract\Components\ArticleRepository;

class MakerArticle implements MakerArticlesInterface
{
    private ?Contract $contract = null;
    private ?Credit $credit = null;

    public function __construct(
        private EntityManagerInterface $em
    ){}

    public function setContract(Contract $contract): MakerArticlesInterface
    {
        $this->contract = $contract;
        return $this;
    }

    public function setCredit(Credit $credit): self 
    {
        $this->credit = $credit;
        return $this;
    }

    public function generate(): array
    {
        /** @var ArticleRepository */
        $repository = $this->em->getRepository(Article::class);
        $modelArticles = $repository->findBy(['contractType' => $this->contract::class]);

        /** @var GageCredit $credit */
        $credit = $this->credit;

        $contractParams = [
            '{date}' => (new DateTime())->format('d-m-Y'),
            '{idCredit}' => $credit->getId(),
        ];
        
        $articles = [];

        foreach($modelArticles as $key => $article) {
            $articles[$key]['title'] = $article->getTitle();
            $articles[$key]['description'] = strtr($article->getDescription(), $contractParams);
        }
        
        return $articles;
    }
}