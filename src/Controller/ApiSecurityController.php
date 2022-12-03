<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Persistence\ManagerRegistry;

class ApiSecurityController extends AbstractController
{

    private $jwtManager;
    private $tokenStorageInterface;

    public function __construct(TokenStorageInterface $tokenStorageInterface, JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
        $this->tokenStorageInterface = $tokenStorageInterface;
    }

    #[Route('/api/v1/logout', name: 'app_api_security')]
    public function index(): JsonResponse
    {
        try {
                //code...
                $requestToken = $this->tokenStorageInterface->getToken();
                
                if($requestToken){
                    $decodedJwtToken = $this->jwtManager->decode($requestToken);
                    //$user = $requestToken->getUser();

                    //unset($user->password);
                    return $this->json([        
                        'success'  => "Successfully logged out.",
                        
                    ]);
                }else{
                    return $this->json([        
                        'error'  => 'Unauthorized.'
                    ], 401);
                }
            } catch (\Throwable $th) {
                //throw $th;
                return $this->json([        
                    'error'  => 'Error decoding the token: '.$th->getMessage()
                ],400);
            }
    }
}
