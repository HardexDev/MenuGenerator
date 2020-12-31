<?php

namespace App\Repository;

use App\Entity\Week;
use App\Entity\Aliment;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Aliment|null find($id, $lockMode = null, $lockVersion = null)
 * @method Aliment|null findOneBy(array $criteria, array $orderBy = null)
 * @method Aliment[]    findAll()
 * @method Aliment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlimentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Aliment::class);
    }

    // /**
    //  * @return Aliment[] Returns an array of Aliment objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Aliment
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllByWeekDishesDistinct(Week $week)
    {
        $aliments = array();
        foreach ($week->getNumday() as $day){
            foreach ($day->getIdlunch()->getIddish()->getIdaliment() as $aliment){
                if (!in_array($aliment, $aliments)){
                    $aliments[] = $aliment;
                }
                
            }

            foreach ($day->getIddinner()->getIddish()->getIdaliment() as $aliment){
                if (!in_array($aliment, $aliments)){
                    $aliments[] = $aliment;
                }
                
            }
        }

        return $aliments;
    }

    public function findAllByWeekDessertsDistinct(Week $week)
    {
        $aliments = array();
        foreach ($week->getNumday() as $day){
            foreach ($day->getIdlunch()->getIddessert()->getIdaliment() as $aliment){
                if (!in_array($aliment, $aliments)){
                    $aliments[] = $aliment;
                }
                
            }

            foreach ($day->getIddinner()->getIddessert()->getIdaliment() as $aliment){
                if (!in_array($aliment, $aliments)){
                    $aliments[] = $aliment;
                }
                
            }
        }

        return $aliments;
    }
}
