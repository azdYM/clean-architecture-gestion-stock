<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\Entity\Contract;
use App\Domain\Contract\Components\Article;
use Doctrine\Common\Collections\Collection;
use App\Domain\Contract\Entity\ArticleTrait;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Contract\Components\SignatureLabel;
use App\Domain\Contract\Entity\GeneralContentTrait;
use App\Domain\Contract\Entity\LabelsForSignatureTrait;
use App\Domain\Contract\Repository\GageContractRepository;

#[ORM\Entity(repositoryClass: GageContractRepository::class)]
class GageContract extends Contract
{
    use ArticleTrait;
    use GeneralContentTrait;
    use LabelsForSignatureTrait;

    #[ORM\JoinTable(name: 'articles_gage_contracts')]
    #[ORM\JoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'article_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: Article::class)]
    protected Collection $articles;
    
    #[ORM\JoinTable(name: 'gage_contracts_signature_labels')]
    #[ORM\JoinColumn(name: 'contract_id', referencedColumnName: 'id')]
    #[ORM\InverseJoinColumn(name: 'signature_label_id', referencedColumnName: 'id')]
    #[ORM\ManyToMany(targetEntity: SignatureLabel::class)]
    protected Collection $labelsForSignautre;

    public function __construct()
    {
        parent::__construct();
        $this->articles = new ArrayCollection();
        $this->labelsForSignautre = new ArrayCollection();
    }
}