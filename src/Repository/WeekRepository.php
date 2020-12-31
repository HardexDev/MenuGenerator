<?php

namespace App\Repository;

use DateTime;
use App\Entity\Day;
use App\Entity\Meal;
use App\Entity\Week;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Week|null find($id, $lockMode = null, $lockVersion = null)
 * @method Week|null findOneBy(array $criteria, array $orderBy = null)
 * @method Week[]    findAll()
 * @method Week[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeekRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Week::class);
    }

    // /**
    //  * @return Week[] Returns an array of Week objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Week
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findOneByRandom(array $data) : ?Week
    {
        $mealRepo = $this->getEntityManager()->getRepository(Meal::class);
        $dayChosen = "today";
        if ($data['jour_semaine'] != null){
            $dayChosen = $data['jour_semaine'] . " this week";
        }
        

        $week = new Week();

        for ($i=1 ; $i <= 7 ; $i++){
            $day = new Day();
            $day->setNumDay($i);
            $day->setDayName("Jour $i");
            $day->setIdlunch($mealRepo->findOneByRandom());
            $day->setIddinner($mealRepo->findOneByRandom());
            $week->addNumday($day);
            $week->setStartdate(new DateTime(date( 'Y-m-d', strtotime( $dayChosen ))));
        }

        return $week;
    }
}
