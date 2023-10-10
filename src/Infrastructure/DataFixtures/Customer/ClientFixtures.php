<?php

namespace App\Infrastructure\DataFixtures\Customer;

use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $gender = ['M', 'F'];
        
        for ($i = 1; $i < 9; $i++) {
            $individual = ClientFactory::create(
                Individual::class, 
                [
                    'name' => "Abdoul-wahid Hassani $i",
                    'folio' => "000$i",
                    'gender' => $gender[rand(0, 1)],
                ]
            );

            $manager->persist($individual);
        }

        for ($i = 10; $i < 19; $i++) {
            $corporate = ClientFactory::create(
                Corporate::class, 
                [
                    'legalForm' => "Cooperation",
                    'name' => "Meck-Moroni $i",
                    'folio' => "000$i",
                    'comercialRegistry' => "00000$i",
                    'activityDomain' => 'Commerce'
                ]
            );

            $manager->persist($corporate);
        }

        $manager->flush();
    }
}