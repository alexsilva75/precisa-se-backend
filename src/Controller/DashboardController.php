<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();
        
        if($user->getType() == "FREELANCER")
        {
            return $this->render('dashboard/freelancer.html.twig', [
                'controller_name' => 'DashboardController',
            ]);
        }else{
            return $this->render('dashboard/customer.html.twig', [
                'controller_name' => 'DashboardController',
            ]);
        }
    }
}
