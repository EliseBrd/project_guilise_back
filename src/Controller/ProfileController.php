<?php

declare(strict_types=1);

// src/Controller/ProfileController.php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/api/profile', name: 'api_profile', methods: ['GET'])]
    public function profile(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            // Pas connecté
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        return $this->json([
            'email' => $user->getEmail(),
            'roles' => $user->getRoles(),
            'surname' => $user->getSurname(),
            'lastname' => $user->getLastname(),
        ]);
    }

    #[Route('/api/logout', name: 'api_logout', methods: ['POST'])]
    public function logout(Request $request): JsonResponse
    {
        $request->getSession()->invalidate();
        return new JsonResponse(['message' => 'Déconnecté avec succès']);
    }

}
