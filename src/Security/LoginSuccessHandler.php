<?php

namespace App\Security;


use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Called when an authentication attempt success.
 *
 * @param Request $request
 * @param TokenInterface $token
 * @return JsonResponse
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $request->getSession()->migrate(true); // Regenerate session ID
        return new JsonResponse(['message' => 'Login successful']);
    }
}
