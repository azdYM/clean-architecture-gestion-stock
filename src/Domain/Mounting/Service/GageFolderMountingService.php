<?php

namespace App\Domain\Mounting\Service;

use App\Domain\Mounting\FolderInterface;
use App\Domain\Mounting\Entity\GageFolder;
use App\Domain\Garantee\Entity\Attestation;
use Doctrine\Common\Collections\Collection;
use App\Domain\Application\Entity\Portfolio;
use App\Domain\Mounting\Exception\MountingFolderException;

class GageFolderMountingService implements FolderMountingServiceInterface
{
    public function mount(Collection $attestations, Portfolio $portfolio): FolderInterface
    {
        $folder = $this->makeGageFolder($attestations)
            ->setPortfolio($portfolio)
        ;
        $this->addFolderInPortfolio($folder, $portfolio);
        return $folder;
    }

    private function makeGageFolder(Collection $attestations): GageFolder
    {
        if ($attestations->count() === 0) {
            throw new MountingFolderException("Aucune attestation n'a été fournis :)");
        }

        if (!$this->creditTypeTargetedIsValid($attestations)) {
            throw new MountingFolderException(
                "Il y a une ambiguité avec les attestations sur le type de crédit ciblé :)"
            );
        }

        return GageFolder::create($attestations);
    }

    /**
     * On verifie si tout les attestations ciblent le même type de crédit
     * Si c'est le cas true est retourné et false sinon
     * 
     * @param Collection $attestations
     * @return boolean
     */
    private function creditTypeTargetedIsValid(Collection $attestations): bool
    {
        $acc = $attestations->reduce(
            function (Attestation $acc, Attestation $actual) {
                if ($acc->getCreditTypeTargeted() !== $actual->getCreditTypeTargeted()) {
                    return $actual;
                } 

                return $acc;
            },
            $attestations->first()
        );

        return $acc->getCreditTypeTargeted() === $attestations->first()->getCreditTypeTargeted();
    }

    private function addFolderInPortfolio(FolderInterface $folder, Portfolio $portfolio): void
    {
        if ($portfolio->getClient() === null) {
            throw new MountingFolderException("Le portefeuille fournis n'est pas associé a aucun client :)");
        }

        $portfolio->addGageCreditFolder($folder);
    }
}