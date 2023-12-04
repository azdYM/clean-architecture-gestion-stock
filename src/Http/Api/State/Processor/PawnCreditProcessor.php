<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Http\Api\DTO\Mounting\Credit;
use App\Http\Api\DTO\Mounting\Folder;
use App\Http\Utils\ObtainClientTrait;
use App\Http\Utils\ObtainFolderTrait;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
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
     * @param Credit $data
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
        
        dd($folder);

        $attestation = $folder->getAttestations()->last();
        $requirements = new CreditRequirements();
        $requirements->attestation = $attestation;
        $requirements->capital = $data->capital;
        $requirements->duration = $data->duration;
        $requirements->startedAt = new \DateTime();

        $interval = \DateInterval::createFromDateString("$data->duration months");
        $requirements->endAt = (new \DateTime())->add($interval);

        dd($requirements);

        $employeeService = new CreditMountingService($this->security->getUser(), $this->event);
        $creditCreationService = new GageCreditCreationService($folder);
        $credit = $employeeService->createCredit($creditCreationService, $requirements);
    }
}