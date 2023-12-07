<?php

namespace App\Domain\Contract;

use App\Domain\Contract\MakerContentInterface;
use App\Domain\Contract\MakerArticlesInterface;

interface CompositionInterface
{
    public function generateAndSetContent(MakerContentInterface $generator): self;
    public function generateAndSetArticles(MakerArticlesInterface $generator): self;
    public function generateAndSetLabelsForSignature(MakerSignatureContainLabels $generator): self;
}