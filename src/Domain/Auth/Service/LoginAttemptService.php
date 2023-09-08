<?php

namespace App\Domain\Auth\Service;

use App\Domain\Auth\Entity\LoginAttempt;
use App\Domain\Auth\Repository\LoginAttemptRepository;
use App\Domain\Auth\User;
use Doctrine\ORM\EntityManagerInterface;

class LoginAttemptService
{
    const ATTEMPTS = 3;

    public function __construct(private LoginAttemptRepository $repository, private EntityManagerInterface $em)
    {}

    public function addAttempt(User $user)
    {
        $attempt = (new LoginAttempt())->setUser($user);
        $this->em->persist($attempt);
        $this->em->flush();
    }

    public function limitReachedFor(User $user): bool
    {
        return $this->repository->countRecentAttemptFor($user, 30) >= self::ATTEMPTS;
    }
}