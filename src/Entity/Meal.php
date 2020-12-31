<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Meal
 *
 * @ORM\Table(name="meal", indexes={@ORM\Index(name="fk_dessertMeal", columns={"idDessert"}), @ORM\Index(name="fk_dishMeal", columns={"idDish"})})
 * @ORM\Entity(repositoryClass="App\Repository\MealRepository")
 */
class Meal
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMeal", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmeal;

    /**
     * @var bool
     *
     * @ORM\Column(name="takeAway", type="boolean", nullable=false)
     */
    private $takeaway;

    /**
     * @var \Dessert
     *
     * @ORM\ManyToOne(targetEntity="Dessert")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDessert", referencedColumnName="idDessert")
     * })
     */
    private $iddessert;

    /**
     * @var \Dish
     *
     * @ORM\ManyToOne(targetEntity="Dish")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDish", referencedColumnName="idDish")
     * })
     */
    private $iddish;

    public function getIdmeal(): ?int
    {
        return $this->idmeal;
    }

    public function getTakeaway(): ?bool
    {
        return $this->takeaway;
    }

    public function setTakeaway(bool $takeaway): self
    {
        $this->takeaway = $takeaway;

        return $this;
    }

    public function getIddessert(): ?Dessert
    {
        return $this->iddessert;
    }

    public function setIddessert(?Dessert $iddessert): self
    {
        $this->iddessert = $iddessert;

        return $this;
    }

    public function getIddish(): ?Dish
    {
        return $this->iddish;
    }

    public function setIddish(?Dish $iddish): self
    {
        $this->iddish = $iddish;

        return $this;
    }


}
