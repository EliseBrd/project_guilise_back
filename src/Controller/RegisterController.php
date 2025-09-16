<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\EntropyService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'app_register', methods: ['POST'])]
    public function index(Request $request, UserService $userService, EntropyService $entropyService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['email'], $data['password'])) {
            return $this->json(['error' => 'Email et mot de passe requis.'], 400);
        }

        $email = $data['email'];
        $password = $data['password'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->json(['error' => 'Email invalide.'], 400);
        }

        if (!$entropyService->checkTotalEntropy($password, 36)) {
            return $this->json(['error' => 'Mot de passe trop faible.'], 400);
        }

        $user = $userService->createUser($email, $password);


        return $this->json(['message' => 'Utilisateur créé.', 'email' => $user->getEmail()]);
    }
}
