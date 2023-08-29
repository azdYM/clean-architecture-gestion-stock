<?php

namespace App\Domain\Contract\Entity;

use Doctrine\Common\Collections\Collection;
use App\Domain\Contract\Components\SignatureLabel;
use App\Domain\Contract\MakerSignatureContainLabels;

trait LabelsForSignatureTrait
{
    public function getLabelsForSignature(): Collection
    {
        return $this->labelsForSignautre;
    }

    public function generateAndSetLabelsForSignature(MakerSignatureContainLabels $creator): self
    {
        $labels = $creator
            ->setContractType(get_called_class())
            ->generate()
        ;
        
        foreach($labels as $label) {
            $this->addLabelForSignature($label);
        }

        return $this;
    }

    private function addLabelForSignature(SignatureLabel $label): self
    {
        if (!$this->labelsForSignautre->contains($label)) {
            $this->labelsForSignautre->add($label);
        }

        return $this;
    }
}