<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;

class ApiCategoryController extends AbstractController
{
    #[Route('/api/v1/category', name: 'app_api_category', methods:['GET'])]
    public function index(ManagerRegistry $doctrine, Request $request): JsonResponse
    {
        $entityManager = $doctrine->getManager();

        $search = $request->query->get('s', null);
        $page = $request->query->get('page',1);

        error_log("Searching Page: $page");
        
        $result = [];
        
        if($search){
            $result = $entityManager->getRepository(Category::class)->findByName($search, $page);
        }else{           
            
            $result = $entityManager->getRepository(Category::class)->findByName("",$page);
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getId();
            },
        ];
        $normalizer = new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);

        $serializer = new Serializer([$normalizer], [$encoder]);
        
        return $this->json([
            'categories' => json_decode($serializer->serialize($result['result'], 'json')),
            'count' => $result['count'],
            'pages' => $result['pages'],
            'currentPage' => $result['currentPage'],
            'prevPage' => $result['prevPage'],
            'nextPage' => $result['nextPage'],
        ],200);
    }

    #[Route('/api/v1/category', name: 'api_categore_store', methods:['POST'])]
    public function store(ManagerRegistry $doctrine, Request $request){
            try {
                //code...
                $entityManager = $doctrine->getManager();
                $repository = $entityManager->getRepository(Category::class);
                $content = json_decode($request->getContent());
                
                $parentId = $content->parent;
                
                $parentCategory =null;
                $category = new Category();

                if($parentId){
                    $parentCategory  = $repository->find($parentId);
                    $category->setParent($parentCategory);
                }                
                
                $category->setName($content->name);                
                $category->setDescription($content->description);
                $category->setColor(isset($content->color) ? $content->color: "#0020ff");
             
                $repository->save($category,true);
                
                return $this->json(['success' => true, 
                'message' => 'New Category persisted.', 
                'id' => $category->getId()], 200);
            } catch (\Throwable $th) {
                //throw $th;
                return $this->json(['success' => false, 
                'message' => 'An error has occurred when saving new Category.'.$th->getMessage()], 400);
            }
        }

        #[Route('/api/v1/category/{id}', name:'api_category_show', methods:['GET'])]
        public function show(Category $category){
            return $this->json(['category' => $category], 200);
        }

        #[Route('/api/v1/category/{id}', name:'api_category_show', methods:['PUT'])]
        public function update(Category $category,ManagerRegistry $doctrine,  Request $request){
            try {
                //code...
                if (!$category) {
                    throw $this->createNotFoundException(
                        'No product found for id '
                    );
                }
                $entityManager = $doctrine->getManager();
                $repository = $entityManager->getRepository(Category::class);
                $content = json_decode($request->getContent());
                $parentId = $content->parent;

                $parentCategory =null;
                if($parentId){
                    $parentCategory  = $repository->find($parentId);
                    $category->setParent($parentCategory);
                }           
                $category->setName($content->name);                
                $category->setDescription($content->description);
                $category->setColor(isset($content->color) ? $content->color: "#0020ff");
                
                $entityManager->flush();
                
                return $this->json(['success' => true, 
                'message' => 'Category updated.', 
                'id' => $category->getId()], 200);
            
            
            } catch (\Throwable $th) {
                //throw $th;
                return $this->json(['success' => false, 
                'message' => 'An error has occurred when updating Category.'.$th->getMessage()], 400);
            }
        }
}
