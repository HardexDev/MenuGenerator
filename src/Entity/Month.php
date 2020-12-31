<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Month
 *
 * @ORM\Table(name="month")
 * @ORM\Entity(repositoryClass="App\Repository\MonthRepository")
 */
class Month
{
    /**
     * @var int
     *
     * @ORM\Column(name="idMonth", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idmonth;

    /**
     * @var string
     *
     * @ORM\Column(name="monthName", type="string", length=255, nullable=false)
     */
    private $monthname;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Aliment", mappedBy="idmonth")
     */
    private $idaliment;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idaliment = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdmonth(): ?int
    {
        return $this->idmonth;
    }

    public function getMonthname(): ?string
    {
        return $this->monthname;
    }

    public function setMonthname(string $monthname): self
    {
        $this->monthname = $monthname;

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
            $idaliment->addIdmonth($this);
        }

        return $this;
    }

    public function removeIdaliment(Aliment $idaliment): self
    {
        if ($this->idaliment->removeElement($idaliment)) {
            $idaliment->removeIdmonth($this);
        }

        return $this;
    }

}
