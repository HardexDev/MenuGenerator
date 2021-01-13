<?php

namespace App\Repository;

use App\Entity\Dish;
use App\Entity\Meal;
use App\Entity\Dessert;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Meal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Meal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Meal[]    findAll()
 * @method Meal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MealRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Meal::class);
    }

    // /**
    //  * @return Meal[] Returns an array of Meal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Meal
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByRandom()
    {
        $dishRepo = $this->getEntityManager()->getRepository(Dish::class);
        $dessertRepo = $this->getEntityManager()->getRepository(Dessert::class);

        $randDish= $dishRepo->findOneByRandom();
        $randDessert= $dessertRepo->findOneByRandom();
        $res = new Meal();
        $res->setIddish($randDish);
        $res->setIddessert($randDessert);
        $res->setTakeaway(false);
        

        return $res;
    }

    public function findByRandom($number, Security $security)
    {
        $dishRepo = $this->getEntityManager()->getRepository(Dish::class);
        $dessertRepo = $this->getEntityManager()->getRepository(Dessert::class);
        
        $allDishes = $dishRepo->findByRandom($number, $security);
        $allDesserts = $dessertRepo->findByRandom($number, $security);
        $allMeals = array();

        for ($i = 0 ; $i<$number ; $i++){
            $randDish= $allDishes[$i];
            $randDessert= $allDesserts[$i];
            $res = new Meal();
            $res->setIddish($randDish);
            $res->setIddessert($randDessert);
            $res->setTakeaway(false);

            array_push($allMeals, $res);
        }
        

        return $allMeals;
    }
}
