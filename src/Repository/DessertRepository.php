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

    public function findOneByRandom() : ?Dessert
    {
        $allDesserts = $this->findAll();
        $res = $allDesserts[array_rand($allDesserts)];

        return $res;
    }

    public function findByRandom($number, array $data)
    {
        $allDesserts = $this->findAll();
        $allDessertsSeasonal = $this->findBySeasonal($allDesserts);

        $desserts = array();

        if ($this->findByYogurt($data) != null){
            foreach ($this->findByYogurt($data) as $yogurt){
                $desserts[] = $yogurt;
            }
            $allYogurtsSeasonal = $this->findBySeasonal($this->findByCategory(5));

            foreach ($allYogurtsSeasonal as $yogurt){
                if (in_array($yogurt, $allDessertsSeasonal)){
                    $key = \array_search($yogurt, $allDessertsSeasonal);
                    unset($allDessertsSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number - count($desserts);

        if ($this->findByCheese($data) != null && count($this->findByCheese($data)) <= $remainingSpace){
            foreach ($this->findByCheese($data) as $cheese){
                $desserts[] = $cheese;
            }
            $allCheesesSeasonal = $this->findBySeasonal($this->findByCategory(6));

            foreach ($allCheesesSeasonal as $cheese){
                if (in_array($cheese, $allDessertsSeasonal)){
                    $key = \array_search($cheese, $allDessertsSeasonal);
                    unset($allDessertsSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number - count($desserts);

        if ($this->findByFruit($data) != null && count($this->findByFruit($data)) <= $remainingSpace){
            foreach ($this->findByFruit($data) as $fruit){
                $desserts[] = $fruit;
            }
            $allFruitsSeasonal = $this->findBySeasonal($this->findByCategory(7));

            foreach ($allFruitsSeasonal as $fruit){
                if (in_array($fruit, $allDessertsSeasonal)){
                    $key = \array_search($fruit, $allDessertsSeasonal);
                    unset($allDessertsSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number - count($desserts);

        if ($this->findByGreedy($data) != null && count($this->findByGreedy($data)) <= $remainingSpace){
            foreach ($this->findByGreedy($data) as $greedy){
                $desserts[] = $greedy;
            }
            $allGreedySeasonal = $this->findBySeasonal($this->findByCategory(8));

            foreach ($allGreedySeasonal as $greedy){
                if (in_array($greedy, $allDessertsSeasonal)){
                    $key = \array_search($greedy, $allDessertsSeasonal);
                    unset($allDessertsSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number - count($desserts);

        for ($i=0; $i<$remainingSpace; $i++){
            $randPosition = array_rand($allDessertsSeasonal);
            $desserts[] = $allDessertsSeasonal[$randPosition];
            // unset($allDessertsSeasonal[$randPosition]);
        }

        shuffle($desserts);

        return $desserts;
    }

    public function findByYogurt(array $data){
        $allDesserts = $this->findByCategory(5);
        $desserts = array();

        if ($data['nb_yogurt'] != null && count($allDesserts) >= $data['nb_yogurt']){

            for ($i=0; $i<$data['nb_yogurt']; $i++){
                $randPosition = array_rand($allDesserts);
                $desserts[] = $allDesserts[$randPosition];
                unset($allDesserts[$randPosition]);
            }
            
            return $desserts;
        }   
    }

    public function findByCheese(array $data){
        $allDesserts = $this->findByCategory(6);
        $allDessertsSeasonal = $this->findBySeasonal($allDesserts);
        $desserts = array();

        if ($data['nb_cheese'] != null && count($allDessertsSeasonal) >= $data['nb_cheese']){

            for ($i=0; $i<$data['nb_cheese']; $i++){
                $randPosition = array_rand($allDessertsSeasonal);
                $desserts[] = $allDessertsSeasonal[$randPosition];
                unset($allDessertsSeasonal[$randPosition]);
            }
            
            return $desserts;
        }   
    }

    public function findByFruit(array $data){
        $allDesserts = $this->findByCategory(7);
        $allDessertsSeasonal = $this->findBySeasonal($allDesserts);
        $threeRandomFruits = array();
        for ($i = 0; $i<3; $i++){
            $randPos = array_rand($allDessertsSeasonal);
            $threeRandomFruits[] = $allDessertsSeasonal[$randPos];
            unset($allDessertsSeasonal[$randPos]);
        }

        $desserts = array();

        if ($data['nb_fruit'] != null){

            for ($i=0; $i<$data['nb_fruit']; $i++){
                $randPosition = array_rand($threeRandomFruits);
                $desserts[] = $threeRandomFruits[$randPosition];
            }
            
            return $desserts;
        }   
    }

    public function findByGreedy(array $data){
        $allDesserts = $this->findByCategory(8);
        $allDessertsSeasonal = $this->findBySeasonal($allDesserts);
        $desserts = array();

        if ($data['nb_greedy'] != null && count($allDessertsSeasonal) >= $data['nb_greedy']){

            for ($i=0; $i<$data['nb_greedy']; $i++){
                $randPosition = array_rand($allDessertsSeasonal);
                $desserts[] = $allDessertsSeasonal[$randPosition];
                unset($allDessertsSeasonal[$randPosition]);
            }
            
            return $desserts;
        }   
    }

    public function findByCategory(int $idCat){
        return $this->createQueryBuilder('d')
        ->andWhere('d.idcategory = :val')
        ->setParameter('val', $idCat)
        ->orderBy('d.iddessert', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function findBySeasonal(array $desserts){
        $allDesserts = $desserts;

        // Add only dishes which have seasonal aliments
        $allDessertsSeasonal = array();
        $currentMonth = date('m');
        foreach ($allDesserts as $dessert){
            $dessertSeasonal = true;
            foreach ($dessert->getIdaliment() as $aliment){
                if ($aliment->getIdcategory() == 4 || $aliment->getIdcategory() == 7){
                    $dessertSeasonal = false;
                    foreach ($aliment->getIdmonth() as $month){
                        if ($month->getIdmonth() == $currentMonth){
                            $dessertSeasonal = true;
                        }
                    }
                }
            }

            if (!in_array($dessert, $allDessertsSeasonal) && $dessertSeasonal){
                $allDessertsSeasonal[] = $dessert;
            }
        }

        return $allDessertsSeasonal;
    }
}
