<?php

namespace App\Http\Api\State\Processor;

use ApiPlatform\Metadata\Operation;
use App\Domain\Garantee\DTO\Garantee;
use App\Http\Utils\ObtainClientTrait;
use App\Domain\Credit\Entity\CreditType;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\SecurityBundle\Security;
use App\Http\Api\DTO\Garantee\GoldEvaluation;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Infrastructure\Generator\Item\GoldEvaluator;
use App\Domain\Employee\Service\GageEvaluationService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GoldEvaluationStateProcessor implements ProcessorInterface
{
    use ObtainClientTrait;

    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private EventDispatcherInterface $eventDispacher
    ){}

    /**
     * @param GoldEvaluation $data
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return Garantee
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $garantee = $this->createGarantee($data);
        $attestation = $this->getAttestationFromGarantee($garantee);

        $this->persistArticles($garantee->getArticles());
        $this->persistAttestation($attestation);
        $this->em->flush();

        return $attestation;
    }

    private function createGarantee(GoldEvaluation $data): Garantee
    {
        $garantee = new Garantee();
        $creditTypeTargeted = $this->em->find(CreditType::class, $data->idCreditTypeTargeted);
        
        foreach($data->articles as $article) {
            $garantee->addArticle($article);
        }
        
        $garantee
            ->setClient($this->getClient($data->clientFolio))
            ->setCreditTypeTargeted($creditTypeTargeted)
            ->setDescription($data->description)
        ;
        
        return $garantee;
    }

    private function getAttestationFromGarantee(Garantee $garantee): GaranteeAttestation
    {
        $itemEvaluator = new GoldEvaluator();
        $evaluationService = new GageEvaluationService(
            $this->security->getUser(), 
            $this->eventDispacher
        );

        return $evaluationService->evaluateAndGenerateAttestation($itemEvaluator, $garantee);
    }

    private function persistArticles(Collection $articles): void 
    {
        foreach($articles as $article) {
            $this->em->persist($article);
        }
    }

    private function persistAttestation(GaranteeAttestation $attestation): void 
    {
        $this->em->persist($attestation);
    }
}

