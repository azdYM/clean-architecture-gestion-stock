<?php

namespace App\Domain\Contract\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Contract\Entity\Contract;
use App\Domain\Contract\Entity\ArticleTrait;
use App\Domain\Contract\Entity\GeneralContentTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Domain\Contract\Entity\LabelsForSignatureTrait;
use App\Domain\Contract\Repository\GageContractRepository;

#[ORM\Entity(repositoryClass: GageContractRepository::class)]
class GageContract extends Contract
{
    use GeneralContentTrait;
    use ArticleTrait;
    use LabelsForSignatureTrait;

    /**
     * Ensemble des articles d'un contrat, un article doit contenir un titre et une description
     * 
     * @see Article[]
     * @var array
     */
    #[ORM\Column]
    #[Groups(['Credit:read'])]
    protected array $articles = []; 

    /**
     * Les signatures qui doivent être apposé sur le contrat, il doit avoir une label
     * 
     * @see SignatureLabel[]
     * @var array
     */
    #[ORM\Column]
    #[Groups(['Credit:read'])]
    protected array $labelsForSignature = [];
}