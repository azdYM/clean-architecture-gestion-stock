<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\Entity\Contract;
use App\Domain\Contract\Components\Article;
use App\Domain\Contract\Entity\ArticleTrait;
use App\Domain\Contract\Components\SignatureLabel;
use App\Domain\Contract\Entity\GeneralContentTrait;
use App\Domain\Contract\Entity\LabelsForSignatureTrait;
use App\Domain\Contract\Repository\DeathSolidarityContractRepository;

#[ORM\Entity(repositoryClass: DeathSolidarityContractRepository::class)]
class DeathSolidarityContract extends Contract
{
    use ArticleTrait;
    use GeneralContentTrait;
    use LabelsForSignatureTrait;

    /**
     * Ensemble des articles d'un contrat, un article doit contenir un titre et une description
     * 
     * @see Article[]
     * @var array
     */
    #[ORM\Column]
    protected array $articles = []; 

    /**
     * Les signatures qui doivent être apposé sur le contrat, il doit avoir une label
     * 
     * @see SignatureLabel[]
     * @var array
     */
    #[ORM\Column]
    protected array $labelsForSignature = [];
}