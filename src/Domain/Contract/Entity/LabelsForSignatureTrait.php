<?php

namespace App\Domain\Contract\Entity;

use App\Domain\Contract\MakerSignatureContainLabels;

trait LabelsForSignatureTrait
{
    public function getLabelsForSignature(): array
    {
        return $this->labelsForSignature;
    }

    public function generateAndSetLabelsForSignature(MakerSignatureContainLabels $creator): self
    {
        $labels = $creator
            ->setContract($this)
            ->generate()
        ;
        
        foreach($labels as $label) {
            $this->addLabelForSignature($label);
        }

        return $this;
    }

    /**
     * Ajoute l'article qui devrait contenir un title et description
     * je devrai dabord checker si article contient bien ces valeurs et levé une exception
     * dans le cas contraire, mais je suis fatigué et épuisé, je verrai plus tard
     *
     * @param array $article
     * @return self
     */
    private function addLabelForSignature(array $signatureLabel): self
    {
        $this->labelsForSignautre[] = $signatureLabel;
        return $this;
    }
}