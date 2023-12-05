<?php

namespace App\Http\Utils;

use App\Domain\Customer\Entity\Client;
use App\Domain\Customer\Entity\Corporate;
use App\Domain\Customer\Entity\Individual;
use Doctrine\Common\Collections\Collection;
use App\Http\Api\DTO\Customer\Client as ClientDTO;


trait MapClientEntityToDto {

    private function mapClientEntityToDto(Client $client): ClientDTO
    {
        $dtoClient = new ClientDTO;
        $dtoClient->name = $client->getName();
        $dtoClient->folio = $client->getFolio();
        $this->setLocationsDto($dtoClient, $client->getLocations());
        $this->setContactsDto($dtoClient, $client->getContacts());
        

        if ($client instanceof Individual) {
            $dtoClient->nin = $client->getNin();
            $dtoClient->gender = $client->getGender();
            $dtoClient->nickname = $client->getNickname();
            $dtoClient->birthDay = $client->getBirthDay();
            $dtoClient->birthLocation = $client->getBirthLocation();
        } 

        else if ($client instanceof Corporate) {
            $dtoClient->legalForm = $client->getLegalForm();
            $dtoClient->activityDomain = $client->getActivityDomain();
            $dtoClient->comericialRegistry = $client->getComercialRegistry();
        }

        else {
            throw new \LogicException();
        }
        
        return $dtoClient;
    }

    private function setLocationsDto(ClientDTO $client, Collection $locations) {
        foreach($locations as $key => $location) {
            $client->locations[$key] = $location;
        }
    }

    private function setContactsDto(ClientDTO $client, Collection $contacts) {
        foreach($contacts as $key => $contact) {
            $client->contacts[$key] = $contact;
        }
    }
}