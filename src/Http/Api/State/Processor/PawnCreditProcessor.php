<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Mounting\Credit as CreditDto;
use App\Http\Api\DTO\Mounting\Folder;
use App\Http\Utils\ObtainClientTrait;
use App\Http\Utils\ObtainFolderTrait;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Credit\Entity\Credit;
use Symfony\Bundle\SecurityBundle\Security;
use App\Domain\Mounting\DTO\CreditRequirements;
use App\Domain\Employee\Service\CreditMountingService;
use App\Domain\Credit\Service\GageCreditCreationService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

class PawnCreditProcessor implements ProcessorInterface
{
    use ObtainClientTrait;
    use ObtainFolderTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private EventDispatcherInterface $event,
        private Security $security
    ){}
    
    /**
     * Undocumented function
     *
     * @param CreditDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $folder = $this->getFolder($data->folderId);
        if ($folder === null) {
            throw new NotFoundResourceException(
                sprintf("Aucun dossier de crédit n'est associé à l'identifiant %s", 
                $data->folderId
            ));
        }
        
        $creditRequirements = $this->createCreditRequirements($data);
        $attestation = $folder->getAttestations()->last();
        $creditRequirements->attestation = $attestation;
        
        $employeeService = new CreditMountingService(
            $this->security->getUser(), 
            $this->event
        );

        $creditCreationService = new GageCreditCreationService($folder);
        $credit = $employeeService->createCredit($creditCreationService, $creditRequirements);

        $this->persistCredit($credit);
        $this->em->flush();

        return $credit;
    }

    private function createCreditRequirements(CreditDto $data): CreditRequirements 
    {
        $requirements = new CreditRequirements();
        $requirements->capital = $data->capital;
        $requirements->duration = $data->duration;
        $requirements->interest = 7000;
        $requirements->code = 'ANGR';
        $requirements->idADBankingFolder = 2000;
        $requirements->startedAt = new \DateTime();

        $interval = \DateInterval::createFromDateString("$data->duration months");
        $requirements->endAt = (new \DateTime())->add($interval);

        return $requirements;
    }

    private function persistCredit(Credit $credit)
    {
        $this->em->persist($credit);
    } 
}