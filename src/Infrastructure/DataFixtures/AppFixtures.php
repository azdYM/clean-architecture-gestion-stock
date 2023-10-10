<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Auth\UserRole;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    

    public function load(ObjectManager $manager): void
    {
        
    }
}
