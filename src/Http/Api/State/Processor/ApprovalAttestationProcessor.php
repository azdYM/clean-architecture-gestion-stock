<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Http\Api\DTO\Garantee\Attestation;
use App\Http\Utils\ObtainAttestationTrait;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Domain\Employee\Service\GageSupervisionService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ApprovalAttestationProcessor implements ProcessorInterface
{    
    use ObtainAttestationTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private EventDispatcherInterface $eventDispatcher,
        private WorkflowInterface $attestationGage,
    ){}
    
    /**
     *
     * @param Attestation $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $attestation = $this->getAttestation($uriVariables['id']);
        $supervisorService = new GageSupervisionService(
            $this->security->getUser(),
            $this->eventDispatcher
        );

        $mountingCreditService = $attestation
            ->getCreditTypeTargeted()
            ->getMountingSection()
            ->getMountingFolderService()
        ;

        $this->attestationGage->apply($attestation, 'approve');
        $attestationApproval = $supervisorService->approve($attestation, $mountingCreditService);
        
        $this->em->persist($attestationApproval);
        $this->em->flush();

        return $attestation;
    }
}