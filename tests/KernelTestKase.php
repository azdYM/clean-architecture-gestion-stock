<?php

namespace App\Tests;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class KernelTestKase extends KernelTestCase
{
    protected EntityManagerInterface $em;
    protected ContainerInterface $container;

    public function setUp(): void
    {
        self::bootKernel();
        $this->container = self::getContainer();
        parent::setUp();
        $this->em = $this->container->get(EntityManagerInterface::class);
    }
}