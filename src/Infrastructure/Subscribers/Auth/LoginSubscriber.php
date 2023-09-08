<?php

namespace App\Infrastructure\Subscribers\Auth;

use App\Domain\Auth\Event\BadPasswordLoginEvent;
use App\Domain\Auth\Service\LoginAttemptService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

class LoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoginAttemptService $loginAttemptService, private EventDispatcherInterface $em)
    {}

    public static function getSubscribedEvents()
    {
        return [
            BadPasswordLoginEvent::class => 'onAuthenticationFailure',
            LoginSuccessEvent::class => 'onLogin'
        ];
    }

    public function onAuthenticationFailure(BadPasswordLoginEvent $event)
    {
        $this->loginAttemptService->addAttempt($event->getUser());
    }

    public function onLogin(LoginSuccessEvent $event)
    {

    }
}