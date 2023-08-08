<?php

namespace App\Domain\Credit\Entity\Contract;

use App\Domain\Application\ArticleCreator;
use App\Domain\Application\MultipleArticleCreator;
use App\Domain\Application\ContentCreatorInterface;
use App\Domain\Application\LabelContainSignatureCreator;

interface ComposantsInterface
{
    public function createAndSetGeneralContent(ContentCreatorInterface $creator): self;
    public function createAndSetArticles(ArticleCreator $creator): self;
    public function createAndSetLabelsContainSignature(LabelContainSignatureCreator $creator): self;
}