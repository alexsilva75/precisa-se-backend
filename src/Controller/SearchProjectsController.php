<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchProjectsController extends AbstractController
{
    #[Route('/search/projects', name: 'search_projects')]
    public function index(): Response
    {
        return $this->render('search_projects/index.html.twig', [
            'controller_name' => 'SearchProjectsController',
        ]);
    }

    #[Route('/search/projects', name: 'search_projects',methods:['POST'])]
    public function search(): Response
    {
        return $this->render('search_projects/index.html.twig', [
            'controller_name' => 'SearchProjectsController',
        ]);
    }
}
