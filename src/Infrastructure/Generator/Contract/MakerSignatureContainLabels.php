<?php

namespace App\Infrastructure\Generator\Contract;

use App\Domain\Credit\Entity\Credit;
use App\Domain\Contract\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Contract\Components\SignatureLabel;
use App\Domain\Contract\Components\SignatureLabelRepository;
use App\Domain\Contract\MakerSignatureContainLabels as ContractMakerSignatureContainLabels;

class MakerSignatureContainLabels implements ContractMakerSignatureContainLabels
{
    private ?Contract $contract = null;
    private ?Credit $credit = null;

    public function __construct(
        private EntityManagerInterface $em
    ){}

    public function setContract(Contract $contract): ContractMakerSignatureContainLabels
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
        /** @var SignatureLabelRepository $repository */
        $repository = $this->em->getRepository(SignatureLabel::class);
        $modelSignatures = $repository->findBy(['contractType' => $this->contract::class]);
        
        $signatures = [];

        foreach($modelSignatures as $key => $signature) {
            $signatures[$key]['label'] = $signature->getLable();
        }
        
        return $signatures;
    }
}