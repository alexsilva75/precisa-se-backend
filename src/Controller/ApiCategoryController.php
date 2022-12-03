<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

class ApiCategoryController extends AbstractController
{
    #[Route('/api/v1/category', name: 'app_api_category', methods:['GET'])]
    public function index(ManagerRegistry $doctrine, Request $request): JsonResponse
    {

        $entityManager = $doctrine->getManager();

        $search = $request->query->get('s', null);

        $result = [];
        
        if($search){
            $result = $entityManager->getRepository(Category::class)->findByName($search);
        }else{           
            $result =  $entityManager->getRepository(Category::class)->findAll();
        }

        return $this->json([
            'categories' => $result,
            
        ],200);
    }

    #[Route('/api/v1/category', name: 'api_categore_store', methods:['POST'])]
    public function store(ManagerRegistry $doctrine, Request $request){
        $entityManager = $doctrine->getManager();
        $repository = $entityManager->getRepository(Category::class);

        $category = new Category();
        $category->setName($request->request->get('name'));
        $category->setParent($request->request->get('parent'));
        $category->setDescription($request->request->get('description'));
        $category->setColor($request->request->get('color'));
        $repository->save($category);

        return $this->json(['success' => true, 
                            'message' => 'New Category persisted.', 
                            'id' => $category->id], 200);
    }
}
