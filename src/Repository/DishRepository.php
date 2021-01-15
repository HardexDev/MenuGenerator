<?php

namespace App\Repository;

use App\Entity\Dish;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    public function findByCompareName($d1, $d2){
        if ($d1->getDishname() == $d2->getDishname()){
            return 1;
        } else {
            return 0;
        }
    }

    public function findByRandom($number, array $data)
    {
        // All dishes in database
        $allDishes = $this->findAll();

        // Add only dishes which have seasonal aliments
        $allDishesSeasonal = $this->findBySeasonal($allDishes);

        // array of dishes that will be returned
        $dishes = array();

        if ($this->findByMeat($data) != null){
            foreach ($this->findByMeat($data) as $meat){
                $dishes[] = $meat;
            }
            $allMeatsSeasonal = $this->findBySeasonal($this->findByCategory(1));

            foreach ($allMeatsSeasonal as $meat){
                if (in_array($meat, $allDishesSeasonal)){
                    $key = \array_search($meat, $allDishesSeasonal);
                    unset($allDishesSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number-count($dishes);

        if ($this->findByFish($data) != null && count($this->findByFish($data)) <= $remainingSpace){
            foreach ($this->findByFish($data) as $fish){
                $dishes[] = $fish;
            }
            $allFishesSeasonal = $this->findBySeasonal($this->findByCategory(2));

            // $allDishesSeasonal = array_udiff($allMeatsSeasonal, $allDishesSeasonal, array($this, 'findByCompareName'));
            foreach ($allMeatsSeasonal as $meat){
                if (in_array($meat, $allDishesSeasonal)){
                    $key = \array_search($meat, $allDishesSeasonal);
                    unset($allDishesSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number-count($dishes);

        if ($this->findByEgg($data) != null && count($this->findByEgg($data)) <= $remainingSpace){
            foreach ($this->findByEgg($data) as $egg){
                $dishes[] = $egg;
            }
            $allEggsSeasonal = $this->findBySeasonal($this->findByCategory(3));

            // $allDishesSeasonal = array_udiff($allMeatsSeasonal, $allDishesSeasonal, array($this, 'findByCompareName'));
            foreach ($allEggsSeasonal as $egg){
                if (in_array($egg, $allDishesSeasonal)){
                    $key = \array_search($egg, $allDishesSeasonal);
                    unset($allDishesSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number-count($dishes);

        if ($this->findByVegetable($data) != null && count($this->findByVegetable($data)) <= $remainingSpace){
            foreach ($this->findByVegetable($data) as $vegetable){
                $dishes[] = $vegetable;
            }
            $allVegetablesSeasonal = $this->findBySeasonal($this->findByCategory(4));

            // $allDishesSeasonal = array_udiff($allMeatsSeasonal, $allDishesSeasonal, array($this, 'findByCompareName'));
            foreach ($allVegetablesSeasonal as $vegetable){
                if (in_array($vegetable, $allDishesSeasonal)){
                    $key = \array_search($vegetable, $allDishesSeasonal);
                    unset($allDishesSeasonal[$key]);
                }
            }
        }

        $remainingSpace = $number-count($dishes);

        // Pick random dishes from the final array
        for ($i=0; $i<$remainingSpace; $i++){
            $randPosition = array_rand($allDishesSeasonal);
            $dishes[] = $allDishesSeasonal[$randPosition];
            if ($this->findByMeat($data) == null && $this->findByFish($data) == null && $this->findByEgg($data) == null && $this->findByVegetable($data) == null)
                unset($allDishesSeasonal[$randPosition]);
        }

        shuffle($dishes);

        return $dishes;
    }

    public function findByMeat(array $data){
            $allDishes = $this->findByCategory(1);
            $allDishesSeasonal = $this->findBySeasonal($allDishes);
            $dishes = array();

        if ($data['nb_meat'] != null && count($allDishesSeasonal) >= $data['nb_meat']){

            $i = 0;
            while ($i<$data['nb_meat']){
                $randPosition = array_rand($allDishesSeasonal);
                $dish = $allDishesSeasonal[$randPosition];
                if ($data['remove_dish'] != null){
                    if ($dish != $data['remove_dish']){
                        $dishes[] = $dish;
                        unset($allDishesSeasonal[$randPosition]);
                        $i++;
                    }
                } else {
                    $dishes[] = $dish;
                    unset($allDishesSeasonal[$randPosition]);
                    $i++;
                }

            }
            
            return $dishes;
        }   
    }

    public function findByFish(array $data){
        $allDishes = $this->findByCategory(2);
        $allDishesSeasonal = $this->findBySeasonal($allDishes);
        $dishes = array();

        if ($data['nb_fish'] != null && count($allDishesSeasonal) >= $data['nb_fish']){

            $i = 0;
            while ($i<$data['nb_fish']){
                $randPosition = array_rand($allDishesSeasonal);
                $dish = $allDishesSeasonal[$randPosition];
                if ($data['remove_dish'] != null){
                    if ($dish != $data['remove_dish']){
                        $dishes[] = $dish;
                        unset($allDishesSeasonal[$randPosition]);
                        $i++;
                    }
                } else {
                    $dishes[] = $dish;
                    unset($allDishesSeasonal[$randPosition]);
                    $i++;
                }
            }
            
            return $dishes;
        }
    }

    public function findByEgg(array $data){
        $allDishes = $this->findByCategory(3);
        $allDishesSeasonal = $this->findBySeasonal($allDishes);
        $dishes = array();

        if ($data['nb_egg'] != null && count($allDishesSeasonal) >= $data['nb_egg']){

            $i = 0;
            while ($i<$data['nb_egg']){
                $randPosition = array_rand($allDishesSeasonal);
                $dish = $allDishesSeasonal[$randPosition];
                if ($data['remove_dish'] != null){
                    if ($dish != $data['remove_dish']){
                        $dishes[] = $dish;
                        unset($allDishesSeasonal[$randPosition]);
                        $i++;
                    }
                } else {
                    $dishes[] = $dish;
                    unset($allDishesSeasonal[$randPosition]);
                    $i++;
                }
            }
            
            return $dishes;
        }
    }

    public function findByVegetable(array $data){
        $allDishes = $this->findByCategory(4);
        $allDishesSeasonal = $this->findBySeasonal($allDishes);
        $dishes = array();

        if ($data['nb_vegetable'] != null && count($allDishesSeasonal) >= $data['nb_vegetable']){

            $i = 0;
            while ($i<$data['nb_vegetable']){
                $randPosition = array_rand($allDishesSeasonal);
                $dish = $allDishesSeasonal[$randPosition];
                if ($data['remove_dish'] != null){
                    if ($dish != $data['remove_dish']){
                        $dishes[] = $dish;
                        unset($allDishesSeasonal[$randPosition]);
                        $i++;
                    }
                } else {
                    $dishes[] = $dish;
                    unset($allDishesSeasonal[$randPosition]);
                    $i++;
                }
            }
            
            return $dishes;
        }
    }

    public function findByCategory(int $idCat){
        return $this->createQueryBuilder('d')
        ->andWhere('d.idcategory = :val')
        ->setParameter('val', $idCat)
        ->orderBy('d.iddish', 'ASC')
        ->getQuery()
        ->getResult();
    }

    public function findBySeasonal(array $dishes){
        $allDishes = $dishes;

        // Add only dishes which have seasonal aliments
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

        return $allDishesSeasonal;
    }
}
