<?php

namespace App\Tests\Domain\Garantee;

use App\Domain\Garantee\DTO\Garantee;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;

trait EvaluationGaranteeTrait
{
    private function evaluate(array $requirements): GoldAttestation
    {
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

        return $this->evaluator->evaluateAndGenerateAttestation($this->itemEvaluator, $garantee);
    }
}