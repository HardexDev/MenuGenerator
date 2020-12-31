<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dessert
 *
 * @ORM\Table(name="dessert", indexes={@ORM\Index(name="fk_categoryDessert", columns={"idCategory"})})
 * @ORM\Entity(repositoryClass="App\Repository\DessertRepository")
 */
class Dessert
{
    /**
     * @var int
     *
     * @ORM\Column(name="idDessert", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $iddessert;

    /**
     * @var string
     *
     * @ORM\Column(name="dessertName", type="string", length=255, nullable=false)
     */
    private $dessertname;

    /**
     * @var bool
     *
     * @ORM\Column(name="takeAway", type="boolean", nullable=false)
     */
    private $takeaway = true;

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
     * @ORM\ManyToMany(targetEntity="Aliment", inversedBy="iddessert")
     * @ORM\JoinTable(name="composedessert",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idDessert", referencedColumnName="idDessert")
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

    public function getIddessert(): ?int
    {
        return $this->iddessert;
    }

    public function getDessertname(): ?string
    {
        return $this->dessertname;
    }

    public function setDessertname(string $dessertname): self
    {
        $this->dessertname = $dessertname;

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
