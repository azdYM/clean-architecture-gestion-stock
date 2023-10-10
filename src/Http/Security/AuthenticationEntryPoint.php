<?php

namespace App\Http\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    public function __construct
    (
        private readonly UrlGeneratorInterface $urlGenerator,

    ){}
    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        dd($authException);
        return new RedirectResponse($this->urlGenerator->generate('auth_login'));
    }
}