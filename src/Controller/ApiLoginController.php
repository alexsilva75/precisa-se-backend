<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{
//     #[Route('/api/v1/login', name: 'api_v1_login', methods:['POST'])]
//     public function index(#[CurrentUser] ?User $user): JsonResponse
//     {

//         if (null === $user) {
//             return $this->json([
//                 'message' => 'missing credentials',
//             ], JsonResponse::HTTP_UNAUTHORIZED);
//         }
            
//         $token = null; //...; // somehow create an API token for $user

//         return $this->json([        
//             'user'  => $user->getUserIdentifier(),
//             'token' => $token,
//         ]);
        
//     }
}
