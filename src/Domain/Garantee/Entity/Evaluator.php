<?php

namespace App\Domain\Garantee\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Domain\Garantee\DTO\Garantee;
use App\Domain\Garantee\ItemInterface;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Gold\Gold;
use App\Domain\Garantee\Entity\GageSection;
use App\Domain\Garantee\EvaluatorInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Garantee\AttestationInterface;
use App\Domain\Application\ItemEvaluatorException;
use App\Domain\Application\ItemEvaluatorInterface;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Domain\Garantee\Event\EvaluationCreatedEvent;
use App\Domain\Garantee\WorkingEvaluationSectionTrait;

#[ORM\Entity]
class Evaluator extends Employee implements EvaluatorInterface
{
    use WorkingEvaluationSectionTrait;

    #[ORM\ManyToOne(targetEntity: GageSection::class, inversedBy: 'evaluators')]
    #[ORM\JoinColumn(name: 'gage_section_id', referencedColumnName: 'id')]
    private ?GageSection $gageSection = null;
    
    private ItemEvaluatorInterface $itemEvaluator;

    /**
     * Evalue une garantie en utilisant un evaluateur tier. L'évaluateur va fournir le prix 
     * unitaire de chaque item contenu dans la garantie. On genere une attestation,
     * et enfin on publie une évènement pour la validation de l'attestation
     *
     * @param Garantee $garantee
     * @return AttestationInterface
     */
    public function evaluateAndGenerateAttestation(ItemEvaluatorInterface $evaluator, Garantee $garantee): AttestationInterface
    {
        $this->itemEvaluator = $evaluator;
        $this->evaluateItemsForGarantee($garantee);
        $attestation = $this->generateAttestationFromGarantee($garantee);
        
        $this->event->dispatch(new EvaluationCreatedEvent(
            $attestation, 
            $this->getGageSection()->getEvaluationGageService()
        ));

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

    private function generateAttestationFromGarantee(Garantee $garantee): GoldAttestation
    {
        $attestation = GoldAttestation::create()
            ->setClient($garantee->getClient())
            ->setEvaluator($this)
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
        }
    }
}