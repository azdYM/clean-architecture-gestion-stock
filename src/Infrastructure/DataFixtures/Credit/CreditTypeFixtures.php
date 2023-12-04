<?php

namespace App\Infrastructure\DataFixtures\Credit;

use Doctrine\Persistence\ObjectManager;
use App\Domain\Credit\Entity\CreditType;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CreditTypeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $creditType = (new CreditType())
            ->setLabel('Prêt sur gage')
            ->setName(CreditType::class)
        ;
        
        $manager->persist($creditType);
        $manager->flush();
    }
}