<?php

namespace App\Domain\Mounting\Service;

use App\Domain\Mounting\FolderInterface;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Mounting\Entity\CreditFolder;

interface FolderMountingServiceInterface
{
    public function mount(Collection $attestations, Portfolio $portfolio): CreditFolder;
}