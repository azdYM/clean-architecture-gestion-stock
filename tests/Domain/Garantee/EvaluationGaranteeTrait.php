<?php

namespace App\Tests\Domain\Garantee;

use App\Domain\Employee\Entity\Employee;
use App\Domain\Garantee\DTO\Garantee;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Infrastructure\Generator\Item\GoldEvaluator;
use App\Domain\Employee\Service\GageEvaluationService;
use Symfony\Component\EventDispatcher\EventDispatcher;

trait EvaluationGaranteeTrait
{
    private function evaluate(array $requirements, Employee $evaluator): GoldAttestation
    {
        $itemEvaluator = new GoldEvaluator;
        $service = new GageEvaluationService($evaluator, new EventDispatcher);

        $garantee = (new Garantee())
            ->setClient($this->individual)
            ->setCreditTypeTargeted($this->creditType)
        ;

        foreach ($requirements as $requirement) {
            [
                'name' => $name, 
                'quantity' => $quantity, 
                'carrat' => $carrat, 
                'weight' => $weight
            ] = $requirement;

            $article = $this->createGoldItem($name, $quantity, $carrat, $weight);
            $garantee->addArticle($article);
        }

        return $service->evaluateAndGenerateAttestation($itemEvaluator, $garantee);
    }
}