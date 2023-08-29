<?php

namespace App\Tests\Domain\Mounting;

use App\Tests\FixtureTrait;
use App\Tests\KernelTestKase;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Mounting\Entity\CreditAgent;
use App\Domain\Mounting\DTO\FolderRequirements;
use App\Tests\Domain\Garantee\CreationItemTrait;
use App\Domain\Garantee\Entity\Gold\GoldAttestation;
use App\Tests\Domain\Garantee\EvaluationGaranteeTrait;
use App\Domain\Mounting\Service\GageFolderMountingService;

class FolderMountingTest extends KernelTestKase
{
    use FixtureTrait;
    use CreationItemTrait;
    use EvaluationGaranteeTrait;

    private Individual $individual;
    private CreditAgent $creditAgent;
    private GoldAttestation $attestation;

    public function setUp(): void
    {
        parent::setUp();
        [
            'credit_agent' => $this->creditAgent,
            'gold_attestation' => $this->attestation,
        ] = $this->loadFixtures(['employee', 'credit_type', 'person', 'attestation']);
    }

    public function testGageFolderCreation()
    {
        $montingService = new GageFolderMountingService();
        $folderRequirements = (new FolderRequirements())
            ->addAttestation($this->attestation)
        ;

        $portfolio = $this->attestation->getClient()->getPortfolio();
        $folder = $this->creditAgent->mountFolder($montingService, $folderRequirements);

        $this->assertContains($folder, $portfolio->getGageCreditFolders());
        $this->assertEquals($portfolio, $folder->getPortfolio());
    }
}