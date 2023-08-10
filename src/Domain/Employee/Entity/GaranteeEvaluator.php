<?php

namespace App\Domain\Employee\Entity;

use App\Domain\Employee\ROLE;
use Doctrine\ORM\Mapping as ORM;
use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\Entity\Evaluation;
use App\Domain\Garantee\GaranteeInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use App\Domain\Application\ItemEvaluatorInterface;
use App\Domain\GaranteeEvaluator\Repository\GaranteeEvaluatorRepository;

#[ORM\Entity(repositoryClass: GaranteeEvaluatorRepository::class)]
class GaranteeEvaluator extends Employee
{
    /**
     * @var Collection<int, EvaluationInterface>
     */
    #[ORM\OneToMany(targetEntity: Evaluation::class, mappedBy: 'garanteeEvaluator', cascade: ['persist'])]
    protected Collection $evaluations;

    public function __construct()
    {
        parent::__construct();
        $this->evaluations = new ArrayCollection();
    }

    public function setRoles(array $roles): static
    {
        parent::setRoles([ROLE::PAWN_EVALUATOR]);
        return $this;
    }

    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function evaluate(GaranteeInterface $garantee, ItemEvaluatorInterface $evaluator, ?string $description): self
    {
        foreach ($garantee->getItems() as $item) 
        {
            $value = $evaluator
                ->setItem(clone $item)
                ->generate()
            ;

            $item->setValue($value);
        }
        
        $evaluation = (new Evaluation())
            ->setDescriptionEvaluator($description)
            ->setGaranteeEvaluated($garantee)
            ->setEvaluator($this)
        ;

        $this->addEvaluation($evaluation);
        return $this;
    }

    private function addEvaluation(Evaluation $evaluation): self
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
        }

        return $this;
    }
}