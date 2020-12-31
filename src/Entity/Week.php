<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Week
 *
 * @ORM\Table(name="week")
 * @ORM\Entity(repositoryClass="App\Repository\WeekRepository")
 */
class Week
{
    /**
     * @var int
     *
     * @ORM\Column(name="idWeek", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idweek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date", nullable=false)
     */
    private $startdate;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Day", inversedBy="idweek", cascade="persist")
     * @ORM\JoinTable(name="composeweek",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idWeek", referencedColumnName="idWeek")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="numDay", referencedColumnName="numDay")
     *   }
     * )
     */
    private $numday;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Client", mappedBy="idweek")
     */
    private $idclient;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->numday = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idclient = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdweek(): ?int
    {
        return $this->idweek;
    }

    public function getStartdate(): ?\DateTimeInterface
    {
        return $this->startdate;
    }

    public function setStartdate(\DateTimeInterface $startdate): self
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * @return Collection|Day[]
     */
    public function getNumday(): Collection
    {
        return $this->numday;
    }

    public function addNumday(Day $numday): self
    {
        if (!$this->numday->contains($numday)) {
            $this->numday[] = $numday;
        }

        return $this;
    }

    public function removeNumday(Day $numday): self
    {
        $this->numday->removeElement($numday);

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getIdclient(): Collection
    {
        return $this->idclient;
    }

    public function addIdclient(Client $idclient): self
    {
        if (!$this->idclient->contains($idclient)) {
            $this->idclient[] = $idclient;
            $idclient->addIdweek($this);
        }

        return $this;
    }

    public function removeIdclient(Client $idclient): self
    {
        if ($this->idclient->removeElement($idclient)) {
            $idclient->removeIdweek($this);
        }

        return $this;
    }

}
