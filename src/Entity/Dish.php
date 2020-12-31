<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dish
 *
 * @ORM\Table(name="dish", indexes={@ORM\Index(name="fk_categoryDish", columns={"idCategory"})})
 * @ORM\Entity(repositoryClass="App\Repository\DishRepository")
 */
class Dish
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDish", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddish;

    /**
     * @var string
     *
     * @ORM\Column(name="dishName", type="string", length=255, nullable=false)
     */
    private $dishname;

    /**
     * @var bool
     *
     * @ORM\Column(name="takeAway", type="boolean", nullable=false)
     */
    private $takeaway = false;

    /**
     * @var \Category
     *
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCategory", referencedColumnName="idCategory")
     * })
     */
    private $idcategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aliment", inversedBy="iddish")
     * @ORM\JoinTable(name="composedish",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idDish", referencedColumnName="idDish")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idAliment", referencedColumnName="idAliment")
     *   }
     * )
     */
    private $idaliment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idaliment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIddish(): ?int
    {
        return $this->iddish;
    }

    public function getDishname(): ?string
    {
        return $this->dishname;
    }

    public function setDishname(string $dishname): self
    {
        $this->dishname = $dishname;

        return $this;
    }

    public function getIdcategory(): ?Category
    {
        return $this->idcategory;
    }

    public function setIdcategory(?Category $idcategory): self
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * @return Collection|Aliment[]
     */
    public function getIdaliment(): Collection
    {
        return $this->idaliment;
    }

    public function addIdaliment(Aliment $idaliment): self
    {
        if (!$this->idaliment->contains($idaliment)) {
            $this->idaliment[] = $idaliment;
        }

        return $this;
    }

    public function removeIdaliment(Aliment $idaliment): self
    {
        $this->idaliment->removeElement($idaliment);

        return $this;
    }

}
