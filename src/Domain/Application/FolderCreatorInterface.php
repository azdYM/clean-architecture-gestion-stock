<?php

namespace App\Domain\Application;

use App\Domain\Customer\ClientInterface;
use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;

interface FolderCreatorInterface
{
    public function setClient(ClientInterface $client): self;
    
    /**
     * @param Collection<int, GaranteeInterface> $garantees
     */
    public function setGarantees(Collection $garantees): self;
    public function create(): FolderInterface;
}