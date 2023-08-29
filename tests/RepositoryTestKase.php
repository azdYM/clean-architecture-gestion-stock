<?php

namespace App\Tests;

class RepositoryTestKase extends KernelTestKase
{
    protected $repository;

    protected $repositoryEntity = null;

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->container->get($this->repositoryEntity);
    }
}