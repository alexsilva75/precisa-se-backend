<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Common\Collections\Criteria;
/**
 * @extends ServiceEntityRepository<Category>
 *
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function save(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Category $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Category[] Returns an array of Category objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Category
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

   public function findByName($value, $page = 1): array
   {

        $maxResults = 10;
        $count = $this->createQueryBuilder('c')
        ->select('count(c.name)')
        ->andWhere('lower(c.name) LIKE lower(:val)')
        ->setParameter('val', "%$value%")
        ->getQuery()
        ->getSingleScalarResult();

        $pages = ceil($count / $maxResults);
        $currentPage = $page;

        $prevPage = $currentPage > 1? $currentPage - 1 : null;
        $nextPage = $currentPage < $pages? $currentPage + 1: null;

        /** The offset to search the result from. */
        $firstResult = $page * 10 - 10;

       $result =  $this->createQueryBuilder('c')
           ->andWhere('lower(c.name) LIKE lower(:val)')
           ->setParameter('val', "%$value%")
           ->orderBy('c.name', 'ASC')
           ->setMaxResults(10)
           ->setFirstResult($firstResult)           
           ->getQuery()
           ->getResult()
       ;

       return [
                'result' => $result, 
                'count' => $count, 
                'pages' => $pages,
                'currentPage' => $currentPage,
                'prevPage' => $prevPage,
                'nextPage' => $nextPage,
            ];
   }

}
