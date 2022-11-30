<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ApiUsersController extends AbstractController
{
    #[Route('/api/v1/users', name: 'app_api_users')]
    public function index(ManagerRegistry $doctrine, Request $request): JsonResponse    
    {
        $entityManager = $doctrine->getManager();


        return $this->json([
            'users' => $entityManager->getRepository(User::class)
                            ->findByFirstInitial($request->query->get("firstInitial")),
           
        ]);
    }
}
