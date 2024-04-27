<?php

namespace App\Http\Api\State\Provider;

use ApiPlatform\Metadata\Operation;
use App\Domain\Credit\Entity\Credit;
use ApiPlatform\State\ProviderInterface;
use App\Http\Utils\MapFolderEntityToDto;
use Doctrine\ORM\EntityManagerInterface;
use App\Http\Utils\MapContractEntityToDto;
use App\Http\Api\DTO\Credit\Credit as CreditDto;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Domain\Credit\Entity\ShortTerm\GageCredit;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class CreditProvider implements ProviderInterface
{
    use MapFolderEntityToDto;
    use MapContractEntityToDto;

    public function __construct
    (
        private EntityManagerInterface $em,
        private WorkflowInterface $attestationGage,

    ){}
    
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->getAllCredits();
        }
        
        $id = $uriVariables['id'];
        /** @var Credit */
        $credit = $this->em->find(Credit::class, $id);
        if ($credit === null) {
            throw new NotFoundResourceException(sprintf(
                'Impossible de trouver le crédit %s', $id
            ));
        }

        $dtoCredit = $this->mapEntityToDto($credit);
        return $dtoCredit;
    }

    private function mapEntityToDto(Credit $credit): CreditDto 
    {
        $dtoCredit = new CreditDto();
        $dtoCredit->id = $credit->getId();
        $dtoCredit->folder = $this->mapFolderEntityToDto($credit->getFolder());
        $dtoCredit->updatedAt = $credit->getUpdatedAt();
        $dtoCredit->currentPlace = $credit->getCurrentPlace() ?? 'created';
        $dtoCredit->creditAgent = $credit->getCreditAgent();
        
        foreach($credit->getContracts() as $key => $contract) {
            $dtoCredit->contracts[$key] = $this->mapContractToDto($contract);
        }
        
        if ($credit instanceof GageCredit) {
            $dtoCredit->idADBankingFolder = $credit->getIdADBankingFoder();
            $dtoCredit->duration = $credit->getDuration();
            $dtoCredit->startedAt = $credit->getStartedAt();
            $dtoCredit->endAt = $credit->getEndAt();
            $dtoCredit->interest = $credit->getInterest();
            $dtoCredit->capital = $credit->getCapital();
            $dtoCredit->code = $credit->getCode();
        }

        return $dtoCredit;
    }

    private function getAllCredits(): array
    {
        $credits = $this->em->getRepository(Credit::class)->findAll();
        $dtoCollectionCredit = [];

        foreach($credits as $key => $credit) {
            $dtoCollectionCredit[$key] = $this->mapEntityToDto($credit);
        }
        
        return $dtoCollectionCredit;
    }
}