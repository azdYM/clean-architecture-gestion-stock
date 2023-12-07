<?php

namespace App\Infrastructure\Generator\Contract;

use App\Domain\Contract\Components\GeneralContent;
use App\Domain\Contract\Components\GeneralContentRepository;
use App\Domain\Contract\Entity\Contract;
use App\Domain\Credit\Entity\Credit;
use App\Domain\Contract\MakerContentInterface;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class MakerContent implements MakerContentInterface
{
    private ?Contract $contract = null;

    private Credit $credit;

    public function __construct(
        private EntityManagerInterface $em
    ){}

   public function setContract(Contract $contract): MakerContentInterface
   {
        $this->contract = $contract;
        return $this;
   }

    public function setCredit(Credit $credit): self 
    {
        $this->credit = $credit;
        return $this;
    }

    public function generate(): string
    {
        /** @var GeneralContentRepository */
        $repository = $this->em->getRepository(GeneralContent::class);
        $generalContent = $repository->findOneBy(['contractType' => $this->contract::class]);

        if ($generalContent === null) {
            throw new NotFoundResourceException(sprintf(
                "Le contrat de type %s n'existe pas", $this->contract::class
            ));
        }

        /** @var GageCredit $credit */
        $credit = $this->credit;

        $contractParams = [
            '{capital}' => $credit->getCapital(),
            '{period}' => $credit->getDuration(),
            '{started}' => $credit->getStartedAt()->format('d-m-Y H:i:s'),
            '{end}' => $credit->getEndAt()->format('d-m-Y H:i:s'),
            '{interest}' => $credit->getInterest(),
        ];

        $contentContract = strtr($generalContent->getDescription(), $contractParams);
        return $contentContract;
    }
}