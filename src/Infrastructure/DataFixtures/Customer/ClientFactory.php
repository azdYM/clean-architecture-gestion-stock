<?php

namespace App\Infrastructure\DataFixtures\Customer;

use ReflectionClass;
use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;

class ClientFactory
{
    public static function create(string $clientType, array $informationsForClient): Client
    {
        $reflexionClass = new ReflectionClass($clientType);

        /** @var Individual|Corporate $client */
        $client = $reflexionClass->newInstance();
        
        if (!$client instanceof Client) {
            throw new \Exception(sprintf("la classe %s n'est pas une classe qui herite de %s", $clientType, Client::class));
        }

        foreach($informationsForClient as $key => $value) {
            match ($key) {
                'name' => $client->setName($value),
                'folio' => $client->setFolio($value),
                'nickname' => $client->setNickname($value),
                'gender' => $client->setGender($value),
                'legalForm' => $client->setLegalForm($value),
                'comercialRegistry' => $client->setComercialRegistry($value),
                'activityDomain' => $client->setActivityDomain($value),
            };
        }

        $client->makePortfolio();

        if ($client instanceof Individual) {
            self::addInformationAboutIndividual($client);
            return $client;
        }

        self::addInformationAboutCorporate($client);
        return $client;
    }

    private static function addInformationAboutIndividual(Individual $client)
    {

    }

    private static function addInformationAboutCorporate(Corporate $client)
    {

    }
}