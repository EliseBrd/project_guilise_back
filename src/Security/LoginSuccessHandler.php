<?php

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

namespace App\Security;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
{
$request->getSession()->migrate(true); // Regenerate session ID
return new JsonResponse(['message' => 'Login successful']);
}
}
