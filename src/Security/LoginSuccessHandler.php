<?php

namespace App\Security;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $session = $request->getSession();
        $session->migrate(true); // Regénère l’ID de session

        // Crée la réponse JSON
        $response = new JsonResponse(['message' => 'Login successful']);

        // Ajoute le cookie explicitement (optionnel si SameSite/credentials OK)
        $response->headers->setCookie(
            Cookie::create(session_name(), $session->getId())
                ->withPath('/')
                ->withDomain(null)          // localhost
                ->withSecure(false)         // true si HTTPS
                ->withHttpOnly(true)
                ->withSameSite('lax')       // Lax ou None si cross-origin HTTPS
        );

        return $response;
    }
}
