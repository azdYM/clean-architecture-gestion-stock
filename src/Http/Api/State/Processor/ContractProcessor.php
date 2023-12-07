<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Credit\Contract;
use App\Http\Utils\ObtainCreditTrait;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Employee\Service\CreditMountingService;
use App\Infrastructure\Generator\Contract\MakerArticle;
use App\Infrastructure\Generator\Contract\MakerContent;
use App\Infrastructure\Generator\Contract\MakerSignatureContainLabels;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ContractProcessor implements ProcessorInterface
{
    use ObtainCreditTrait;
    
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private EventDispatcherInterface $eventDispatcher,
        private MakerContent $makerContent,
        private MakerArticle $makerArticle,
        private MakerSignatureContainLabels $makerSignatureContainLabels
    ){}
    
    /**
     *
     * @param Contract $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $credit = $this->getCredit($data->creditId);

        $this->makerContent->setCredit($credit);
        $this->makerArticle->setCredit($credit);
        $this->makerSignatureContainLabels->setCredit($credit);

        $generateContractService = new CreditMountingService(
            $this->security->getUser(),
            $this->eventDispatcher
        );

        $contracts = $generateContractService->generateContractsForGageCredit(
            $credit,
            $this->makerContent,
            $this->makerArticle,
            $this->makerSignatureContainLabels
        );

        $this->persistContracts($contracts);
        $this->em->flush();

        return $credit;
    }

    public function persistContracts(Collection $contracts): void 
    {
        foreach($contracts as $contract) {
            $this->em->persist($contract);
        }
    }
}