<?php

namespace App\Domain\Application;

interface PortfolioCreatorInterface
{
    public function getPortfolio(): PortfolioInterface;
    public function createPortfolio(): void;
}