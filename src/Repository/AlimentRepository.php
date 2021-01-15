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

    private function findAllBySort(&$aliments, $props){
        usort($aliments, function($a, $b) use ($props) {
            if($a['alimentObject']->getIdcategory() == $b['alimentObject']->getIdcategory())
                return strnatcmp($a['alimentObject']->getAlimentname(), $b['alimentObject']->getAlimentname()) > 0 ? 1 : -1;
            return $a['alimentObject']->getIdcategory() > $b['alimentObject']->getIdcategory() ? 1 : -1;
        });
    }

    public function findAllByWeekDishesDistinct(Week $week){
        $aliments = array();
        foreach ($week->getNumday() as $day){
            foreach ($day->getIdlunch()->getIddish()->getIdaliment() as $aliment){
                $in_array = false;
                foreach ($aliments as $ali){
                    if ($ali['alimentObject'] == $aliment)
                        $in_array = true;
                }
                if (!$in_array){
                    $aliments[] = array(
                        'alimentObject' => $aliment,
                        'count' => 1
                    );
                } else {
                    $key = null;
                    foreach ($aliments as $index => $a){
                        $id = $a['alimentObject'];
                        if ($id == $aliment){
                            $key = $index;
                        }
                    }

                    $newCount = $aliments[$key]['count'] + 1;
                    $aliments[$key]['count'] = $newCount;

                    
                }
                
            }

            foreach ($day->getIddinner()->getIddish()->getIdaliment() as $aliment){
                $in_array = false;
                foreach ($aliments as $ali){
                    if ($ali['alimentObject'] == $aliment)
                        $in_array = true;
                }
                if (!$in_array){
                    $aliments[] = array(
                        'alimentObject' => $aliment,
                        'count' => 1
                    );
                } else {
                    $key = null;
                    foreach ($aliments as $index => $a){
                        $id = $a['alimentObject'];
                        if ($id == $aliment){
                            $key = $index;
                        }
                    }

                    $newCount = $aliments[$key]['count'] + 1;
                    $aliments[$key]['count'] = $newCount;

                    
                }
                
            }
        }

        $this->findAllBySort($aliments, array("idcategory()", "getAlimentname()"));

        return $aliments;
    }

    public function findAllByWeekDessertsDistinct(Week $week)
    {
        $aliments = array();
        foreach ($week->getNumday() as $day){
            foreach ($day->getIdlunch()->getIddessert()->getIdaliment() as $aliment){
                $in_array = false;
                foreach ($aliments as $ali){
                    if ($ali['alimentObject'] == $aliment)
                        $in_array = true;
                }
                if (!$in_array){
                    $aliments[] = array(
                        'alimentObject' => $aliment,
                        'count' => 1
                    );
                } else {
                    $key = null;
                    foreach ($aliments as $index => $a){
                        $id = $a['alimentObject'];
                        if ($id == $aliment){
                            $key = $index;
                        }
                    }

                    $newCount = $aliments[$key]['count'] + 1;
                    $aliments[$key]['count'] = $newCount;

                    
                }
                
            }

            foreach ($day->getIddinner()->getIddessert()->getIdaliment() as $aliment){
                $in_array = false;
                foreach ($aliments as $ali){
                    if ($ali['alimentObject'] == $aliment)
                        $in_array = true;
                }
                if (!$in_array){
                    $aliments[] = array(
                        'alimentObject' => $aliment,
                        'count' => 1
                    );
                } else {
                    $key = null;
                    foreach ($aliments as $index => $a){
                        $id = $a['alimentObject'];
                        if ($id == $aliment){
                            $key = $index;
                        }
                    }

                    $newCount = $aliments[$key]['count'] + 1;
                    $aliments[$key]['count'] = $newCount;

                    
                }
                
            }
        }

        $this->findAllBySort($aliments, array("idcategory()", "getAlimentname()"));

        return $aliments;
    }
}
