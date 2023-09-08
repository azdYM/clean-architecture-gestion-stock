<?php

namespace App\Infrastructure\DataFixtures;

use App\Domain\Auth\User;
use App\Domain\Auth\UserRole;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

abstract class UserFactory
{
    protected static ?User $user = null;

    abstract public static function create(?UserRole $role = null, ?array $infos = []);

    protected static function setDefaultUserInformations(array $informations = [])
    {
        [
            'email' => $email, 
            'username' => $username, 
        ] = $informations;

        if (is_null(self::$user)) {
            throw new UserNotFoundException('L\'utilisateur ne doit pas être nulle');
        }

        self::$user
            ->setEmail($email)
            ->setUsername($username)
        ;
    }
}