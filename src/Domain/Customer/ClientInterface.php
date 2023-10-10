<?php

namespace App\Domain\Customer;

use App\Domain\Application\Entity\Portfolio;

/**
 * L'interface ClientInterface sert à définir un ensemble de méthodes que chaque classe de 
 * client (par exemple, les classes Individual, Corporate, etc.) doit fournir. 
 * Les classes de clients implémenteront cette interface en fournissant des implémentations spécifiques 
 * pour chaque méthode définie, ce qui garantit que toutes les classes de clients 
 * se conforment au même contrat et peuvent être utilisées de manière cohérente dans le système.
 */
interface ClientInterface
{
    public function getFolio(): ?int;
    public function getMembershipAt(): ?\DateTimeInterface;
    public function getPortfolio(): ?Portfolio;
}