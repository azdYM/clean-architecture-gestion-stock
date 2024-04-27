<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Workflow\WorkflowInterface;
use App\Http\Api\DTO\Garantee\Attestation as AttestationDto;
use App\Http\Utils\ObtainAttestationTrait;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ValidationAttestationProcessor implements ProcessorInterface
{    
    use ObtainAttestationTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private WorkflowInterface $attestationGage,
        private Security $security,
    ){}
    
    /**
     * @param AttestationDto $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $attestation = $this->getAttestation($uriVariables['id']);
        if ($attestation->getEvaluator() !== $this->security->getUser()) {
            throw new AccessDeniedException("Accès refusé. Vous n'avez pas l'autorisation nécessaire.");
        }

        $attestation->setUpdatedAt(new \DateTime());
        $this->attestationGage->apply($attestation, 'validate_evaluation');
        $this->em->flush();

        return $attestation;
    }
}