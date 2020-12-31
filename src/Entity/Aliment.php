<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Aliment
 *
 * @ORM\Table(name="aliment")
 * @ORM\Entity(repositoryClass="App\Repository\AlimentRepository")
 */
class Aliment
{
    /**
     * @var int
     *
     * @ORM\Column(name="idAliment", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idaliment;

    /**
     * @var string
     *
     * @ORM\Column(name="alimentName", type="string", length=255, nullable=false)
     */
    private $alimentname;

    /**
     * @var string
     *
     * @ORM\Column(name="idCategory", type="string", length=1, nullable=false, options={"fixed"=true})
     */
    private $idcategory;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Month", inversedBy="idaliment")
     * @ORM\JoinTable(name="beseasonal",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idAliment", referencedColumnName="idAliment")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idMonth", referencedColumnName="idMonth")
     *   }
     * )
     */
    private $idmonth;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Dessert", mappedBy="idaliment")
     */
    private $iddessert;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Dish", mappedBy="idaliment")
     */
    private $iddish;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idmonth = new \Doctrine\Common\Collections\ArrayCollection();
        $this->iddessert = new \Doctrine\Common\Collections\ArrayCollection();
        $this->iddish = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdaliment(): ?int
    {
        return $this->idaliment;
    }

    public function getAlimentname(): ?string
    {
        return $this->alimentname;
    }

    public function setAlimentname(string $alimentname): self
    {
        $this->alimentname = $alimentname;

        return $this;
    }

    public function getIdcategory(): ?string
    {
        return $this->idcategory;
    }

    public function setIdcategory(string $idcategory): self
    {
        $this->idcategory = $idcategory;

        return $this;
    }

    /**
     * @return Collection|Month[]
     */
    public function getIdmonth(): Collection
    {
        return $this->idmonth;
    }

    public function addIdmonth(Month $idmonth): self
    {
        if (!$this->idmonth->contains($idmonth)) {
            $this->idmonth[] = $idmonth;
        }

        return $this;
    }

    public function removeIdmonth(Month $idmonth): self
    {
        $this->idmonth->removeElement($idmonth);

        return $this;
    }

    /**
     * @return Collection|Dessert[]
     */
    public function getIddessert(): Collection
    {
        return $this->iddessert;
    }

    public function addIddessert(Dessert $iddessert): self
    {
        if (!$this->iddessert->contains($iddessert)) {
            $this->iddessert[] = $iddessert;
            $iddessert->addIdaliment($this);
        }

        return $this;
    }

    public function removeIddessert(Dessert $iddessert): self
    {
        if ($this->iddessert->removeElement($iddessert)) {
            $iddessert->removeIdaliment($this);
        }

        return $this;
    }

    /**
     * @return Collection|Dish[]
     */
    public function getIddish(): Collection
    {
        return $this->iddish;
    }

    public function addIddish(Dish $iddish): self
    {
        if (!$this->iddish->contains($iddish)) {
            $this->iddish[] = $iddish;
            $iddish->addIdaliment($this);
        }

        return $this;
    }

    public function removeIddish(Dish $iddish): self
    {
        if ($this->iddish->removeElement($iddish)) {
            $iddish->removeIdaliment($this);
        }

        return $this;
    }

}
