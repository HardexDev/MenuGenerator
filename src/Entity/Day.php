<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Day
 *
 * @ORM\Table(name="day", indexes={@ORM\Index(name="fk_dinner", columns={"idDinner"}), @ORM\Index(name="fk_lunch", columns={"idLunch"})})
 * @ORM\Entity(repositoryClass="App\Repository\DayRepository")
 */
class Day
{
    /**
     * @var int
     *
     * @ORM\Column(name="numDay", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numday;

    /**
     * @var \Meal
     *
     * @ORM\ManyToOne(targetEntity="Meal", cascade="persist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idDinner", referencedColumnName="idMeal")
     * })
     */
    private $iddinner;

    /**
     * @var \Meal
     *
     * @ORM\ManyToOne(targetEntity="Meal", cascade="persist")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idLunch", referencedColumnName="idMeal")
     * })
     */
    private $idlunch;

    /**
     * @var string
     *
     * @ORM\Column(name="dayName", type="string", length=255, nullable=true)
     */
    private $dayname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Week", mappedBy="numday")
     */
    private $idweek;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idweek = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setNumDay(?int $numday): self
    {
        $this->numday = $numday;

        return $this;
    }

    public function getNumday(): ?int
    {
        return $this->numday;
    }

    public function getIddinner(): ?Meal
    {
        return $this->iddinner;
    }

    public function setIddinner(?Meal $iddinner): self
    {
        $this->iddinner = $iddinner;

        return $this;
    }

    public function getIdlunch(): ?Meal
    {
        return $this->idlunch;
    }

    public function setIdlunch(?Meal $idlunch): self
    {
        $this->idlunch = $idlunch;

        return $this;
    }

    public function getDayName(): ?string
    {
        return $this->dayname;
    }

    public function setDayName(?string $dayname): self
    {
        $this->dayname = $dayname;

        return $this;
    }


    /**
     * @return Collection|Week[]
     */
    public function getIdweek(): Collection
    {
        return $this->idweek;
    }

    public function addIdweek(Week $idweek): self
    {
        if (!$this->idweek->contains($idweek)) {
            $this->idweek[] = $idweek;
            $idweek->addNumday($this);
        }

        return $this;
    }

    public function removeIdweek(Week $idweek): self
    {
        if ($this->idweek->removeElement($idweek)) {
            $idweek->removeNumday($this);
        }

        return $this;
    }

}
