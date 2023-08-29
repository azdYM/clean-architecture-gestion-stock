<?php

namespace App\Tests;

use Fidry\AliceDataFixtures\LoaderInterface;

trait FixtureTrait
{
    public function loadFixtures(array $fixtures)
    {
        $fixturesPath = $this->getFixturesPath();
        $files = array_map(fn ($fixture) => self::join($fixturesPath, $fixture.'.yaml'), $fixtures);
        /** @var LoaderInterface */
        $loader = $this->container->get('fidry_alice_data_fixtures.loader.doctrine');
        return $loader->load($files);
    }

    private function getFixturesPath()
    {
        return __DIR__.'/fixtures/';
    }

    public static function join(string ...$parts): string
    {
        return preg_replace('~[/\\\\]+~', DIRECTORY_SEPARATOR, implode(DIRECTORY_SEPARATOR, $parts)) ?: '';
    }
}