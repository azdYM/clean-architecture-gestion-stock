<?php

namespace App\Domain\Auth\Security;

use App\Domain\Auth\User;
use App\Domain\Auth\Service\LoginAttemptService;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Domain\Auth\Exception\TooManyBadCredentialsException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class UserChecker implements UserCheckerInterface
{
    public function __construct(private readonly LoginAttemptService $loginAttemptService)
    {}

    /**
     * Véfifie que l'utilisateur a le droit de se connecter
     *
     * @param UserInterface $user
     * @return void
     */
    public function checkPreAuth(UserInterface $user)
    {
        if ($user instanceof User && $this->loginAttemptService->limitReachedFor($user)) {
            throw new TooManyBadCredentialsException();
        }

        return;
    }

    /**
     * Vérifie que l'utilisateur connécté a le droit de continuer
     *
     * @param UserInterface $user
     * @return void
     */
    public function checkPostAuth(UserInterface $user)
    {
        
    }
}