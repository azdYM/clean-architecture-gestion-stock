<?php

namespace App\Domain\Application;

use App\Domain\Customer\ClientInterface;
use Doctrine\Common\Collections\Collection;

interface PortfolioInterface
{
    public function getClient(): ClientInterface;

    /**
     * Obtenir Tous les dossier contenant des prêts a court terme. Il peut s'agir des prêt sur gage, 
     * prêt étudiant ou encore des prêt coud de pouce
     * 
     * @return Collection<int, FolderInterface>
     */
    public function getLongTermCredits(): Collection;

    /**
     * Obtenir tous les dossiers contenant des prêts à long terme. il s'agit des prêts commercials,
     * productif, salarié ...etc
     * 
     * @return Collection<int, FolderInterface>
     */
    public function getShortTermCredits(): Collection;
}