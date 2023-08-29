<?php

namespace App\Domain\Application;

use App\Domain\Customer\ClientInterface;
use Doctrine\Common\Collections\Collection;

interface PortfolioInterface
{
    public function getClient(): ClientInterface;

    /**
     * Obtenir Tous les dossiers contenant les prêts sur gage.
     * 
     * @return Collection<int, FolderInterface>
     */
    public function getGageCreditFolders(): Collection;
}