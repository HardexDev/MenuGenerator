<?php

namespace App\Repository;

use App\Entity\Dessert;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findOneByRandom() : ?Dessert
    {
        $allDesserts = $this->findAll();
        $res = $allDesserts[array_rand($allDesserts)];

        return $res;
    }

    public function findByRandom($number)
    {
        $allDesserts = $this->findAll();
        $desserts = array();

        for ($i=0; $i<$number; $i++){
            $randPosition = array_rand($allDesserts);
            $desserts[] = $allDesserts[$randPosition];
            unset($allDesserts[$randPosition]);
        }

        return $desserts;
    }
}
