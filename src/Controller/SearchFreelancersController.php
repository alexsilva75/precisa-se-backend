<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class SearchFreelancersController extends AbstractController
{
    #[Route('/search/freelancers', name: 'search_freelancers')]
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $searchString =  $request->request->get('s');

        $freelancers = [];
        if(isset($searchString)){
            $entityManager = $doctrine->getManager();
            $freelancers = $entityManager->getRepository(User::class)->findByJobTitleOrExpertise($searchString);
            // return $this->json(['result' => $result]);
        }
        return $this->render('search_freelancers/index.html.twig', [
            'freelancers' => $freelancers,
        ]);
    }
}
