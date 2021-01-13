<?php

namespace App\Repository;

use App\Entity\Aliment;
use App\Entity\Dessert;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Dessert|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dessert|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dessert[]    findAll()
 * @method Dessert[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DessertRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dessert::class);
    }

    // /**
    //  * @return Dessert[] Returns an array of Dessert objects
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
    public function findOneBySomeField($value): ?Dessert
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findAllFruits(){
        return $this->createQueryBuilder('d')
            ->andWhere('d.idcategory = :val')
            ->setParameter('val', 7)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllDessertsExeptFruits(){
        return $this->createQueryBuilder('d')
            ->andWhere('d.idcategory != :val')
            ->setParameter('val', 7)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOneByRandom() : ?Dessert
    {
        $allDesserts = $this->findAll();
        $res = $allDesserts[array_rand($allDesserts)];

        return $res;
    }

    public function findByRandom($number)
    {
        $currentMonth = date('m');
        $allFruits = $this->findAllFruits();
        $seasonalFruits = array();

        foreach ($allFruits as $fruitDessert){
            foreach($fruitDessert->getIdaliment() as $fruit){
                foreach ($fruit->getIdmonth() as $month){
                    if ($month->getIdmonth() == $currentMonth){
                        if (!in_array($fruit, $seasonalFruits)){
                            $seasonalFruits[] = $fruitDessert;
                        }
                    }
                }
            }
            
        }

        $threeRandomFruits = array();

        for ($i = 0; $i<3; $i++){
            $randPos = array_rand($seasonalFruits);
            $threeRandomFruits[] = $seasonalFruits[$randPos];
            unset($seasonalFruits[$randPos]);
        }

        $allDesserts = $this->findAllDessertsExeptFruits();
        $desserts = array();

        for ($i=0; $i<7; $i++){
            $desserts[] = $threeRandomFruits[array_rand($threeRandomFruits)];
        }

        $remainingSpace = $number - count($desserts);

        for ($i=0; $i<$remainingSpace; $i++){
            $randPosition = array_rand($allDesserts);
            $desserts[] = $allDesserts[$randPosition];
            unset($allDesserts[$randPosition]);
        }

        shuffle($desserts);

        return $desserts;
    }
}
