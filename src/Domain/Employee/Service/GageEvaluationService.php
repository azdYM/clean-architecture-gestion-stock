<?php

namespace App\Domain\Employee\Service;

use App\Domain\Garantee\DTO\Garantee;
use App\Domain\Garantee\ItemInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Gold\Gold;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Application\ItemEvaluatorException;
use App\Domain\Application\ItemEvaluatorInterface;
use App\Domain\Garantee\Entity\GaranteeAttestation;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Event\EvaluationCreatedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class GageEvaluationService
{   
    private ItemEvaluatorInterface $itemEvaluator;

    public function __construct
    (
        private Employee $evaluator,
        private EventDispatcherInterface $event
    ){}

    /**
     * Evalue une garantie en utilisant un evaluateur tier. L'évaluateur va fournir le prix 
     * unitaire de chaque item contenu dans la garantie. On genere une attestation,
     * et enfin on publie une évènement pour la validation de l'attestation
     *
     * @param ItemEvaluatorInterface $evaluator
     * @param Garantee $garantee
     * @return AttestationInterface
     */
    public function evaluateAndGenerateAttestation(ItemEvaluatorInterface $evaluator, Garantee $garantee): AttestationInterface
    {
        $this->itemEvaluator = $evaluator;
        $this->evaluateItemsForGarantee($garantee);
        $attestation = $this->generateAttestationFromGarantee($garantee);   
        $this->event->dispatch(new EvaluationCreatedEvent($attestation));

        return $attestation;
    }

    private function evaluateItemsForGarantee(Garantee $garantee): void
    {
        /** @var Gold $item */
        foreach ($garantee->getArticles() as $item) {
            $price = $this->generatePriceForItem($item);
            $item->setUnitPrice($price);
        }
    }

    /**
     * Genere le prix d'une item à travers un evaluateur et ajoute le prix à l'item. 
     * Retourne le prix, si tout s'est bien passé ou une exception de type 
     * ItemEvaluatorException sera lévé dans le cas contraire
     * 
     * @param Gold $item
     * @return bool|\Throwable
     */
    private function generatePriceForItem(Gold $item): int|\Throwable
    {
        try {
            $price = $this->itemEvaluator->setItem(clone $item)->generate();
        } catch (\Throwable $th) {
            throw new ItemEvaluatorException(
                $th,
                sprintf("L'item %s de l'objet %s n'a pas pu être évalué. Merci de résseyer plus tard ou d'appeler AZAD🤣 !", $item->getId(), get_class($item))
            );
        }

        return $price;
    }

    private function generateAttestationFromGarantee(Garantee $garantee): GaranteeAttestation
    {
        $attestation = GoldAttestation::create()
            ->setClient($garantee->getClient())
            ->setEvaluationService($this->evaluator->getCurrentEvaluationSection()->getEvaluationGageService())
            ->setEvaluator($this->evaluator)
            ->setEvaluatorDescription($garantee->getDescription())
            ->setCreditTypeTargeted($garantee->getCreditTypeTargeted())
        ;

        $this->setItemsInAttestation($attestation, $garantee->getArticles());
        return $attestation;
    }

    /**
     * @param AttestationInterface $attestation
     * @param Collection<int, ItemInterface> $items
     * @return void
     */
    private function setItemsInAttestation(AttestationInterface $attestation, Collection $items): void
    {
        foreach($items as $item) {
            $attestation->addItem($item);
            $item->setAttestation($attestation);
        }
    }
}