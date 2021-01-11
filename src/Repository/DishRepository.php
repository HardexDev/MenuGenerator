<?php

namespace App\Repository;

use App\Entity\Dish;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Dish|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dish|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dish[]    findAll()
 * @method Dish[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DishRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dish::class);
    }

    // /**
    //  * @return Dish[] Returns an array of Dish objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Dish
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    */

    public function findOneByRandom() : ?Dish
    {
        $allDishes = $this->findAll();
        $res = $allDishes[array_rand($allDishes)];

        return $res;
    }

    public function findByRandom($number)
    {
        $allDishes = $this->findAll();
        $allDishesSeasonal = array();
        $currentMonth = date('m');
        foreach ($allDishes as $dish){
            $dishSeasonal = true;
            foreach ($dish->getIdaliment() as $aliment){
                if ($aliment->getIdcategory() == 4 || $aliment->getIdcategory() == 7){
                    $dishSeasonal = false;
                    foreach ($aliment->getIdmonth() as $month){
                        if ($month->getIdmonth() == $currentMonth){
                            $dishSeasonal = true;
                        }
                    }
                }
            }

            if (!in_array($dish, $allDishesSeasonal) && $dishSeasonal){
                $allDishesSeasonal[] = $dish;
            }
        }
        $dishes = array();

        for ($i=0; $i<$number; $i++){
            $randPosition = array_rand($allDishesSeasonal);
            $dishes[] = $allDishesSeasonal[$randPosition];
            unset($allDishesSeasonal[$randPosition]);
        }

        return $dishes;
    }
}
