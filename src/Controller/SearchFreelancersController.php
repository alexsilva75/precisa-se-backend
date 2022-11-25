<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchFreelancersController extends AbstractController
{
    #[Route('/search/freelancers', name: 'search_freelancers')]
    public function index(): Response
    {
        return $this->render('search_freelancers/index.html.twig', [
            'controller_name' => 'SearchFreelancersController',
        ]);
    }
}
