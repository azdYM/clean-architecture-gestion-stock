<?php

namespace App\Tests\Domain\Employee\Repository;

use App\Domain\Application\Entity\Portfolio;
use App\Tests\FixtureTrait;
use App\Tests\RepositoryTestKase;
use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use App\Domain\Customer\Repository\PersonRepository;

class ClientRepositoryTest extends RepositoryTestKase
{
    use FixtureTrait;

    protected $repositoryEntity = PersonRepository::class;
    private ?Individual $individual = null;
    private ?Corporate $corporate = null;

    public function setUp(): void
    {
        parent::setUp();
        [
            'individual1' => $this->individual,
            'corporate5' => $this->corporate,
        ] = $this->loadFixtures(['person']);

    }

    public function testIfClientIsIndividual() 
    {
        $this->assertInstanceOf(Individual::class, $this->individual);
    }

    public function testIfClientIsCorporate()
    {
        $this->assertInstanceOf(Corporate::class, $this->corporate);
    }

    public function testPortfolioForClientIsNotNull()
    {
        $individualPortfolio = $this->createPortfolio($this->individual);
        $corporatePortfolio = $this->createPortfolio($this->corporate);

        $this->assertNotNull($individualPortfolio, 'Le client individu n\'a pas de portefeuille');
        $this->assertNotNull($corporatePortfolio, 'Le client individu n\'a pas de portefeuille');
    }

    public function testPortfolioIsCreatedOnceOnlyForSameClient()
    {
        $client = $this->individual;
        $portfolio = $this->createPortfolio($client);

        $this->assertObjectEquals($portfolio, $client->getPortfolio());
    }

    private function createPortfolio(Client $client): Portfolio
    {
        $portfolio = $client->getPortfolio();
        $this->em->persist($client);
        return $portfolio;
    }
}