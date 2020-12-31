<?php

namespace App\Entity;

use App\Entity\Week;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Client
 *
 * @ORM\Table(name="client", indexes={@ORM\Index(name="fk_diet", columns={"idDiet"})})
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @UniqueEntity(fields="email", message="Email déjà utilisée")
 */
class Client implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="idClient", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idclient;

    /**
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255, nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255, nullable=false)
     */
    private $lastname;

    /**
     * @var int
     *
     * @ORM\Column(name="weigth", type="integer", nullable=false)
     */
    private $weigth;

    /**
     * @var int
     *
     * @ORM\Column(name="heigth", type="integer", nullable=false)
     */
    private $heigth;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     * @Assert\Email
     *
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=false)
     * @Assert\Length(min="8", minMessage="Votre mot de passe doit faire minimum 8 caractères")
     */
    private $password;

    /**
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapé le même mot de passe")
     */
    public $confirm_password;

    /**
     * Represents the clean password of the user
     */
    public $cleanPassword;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Week", inversedBy="idclient")
     * @ORM\JoinTable(name="generateweek",
     *   joinColumns={
     *     @ORM\JoinColumn(name="idClient", referencedColumnName="idClient")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="idWeek", referencedColumnName="idWeek")
     *   }
     * )
     */
    private $idweek;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idweek = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdclient(): ?int
    {
        return $this->idclient;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getWeigth(): ?int
    {
        return $this->weigth;
    }

    public function setWeigth(int $weigth): self
    {
        $this->weigth = $weigth;

        return $this;
    }

    public function getHeigth(): ?int
    {
        return $this->heigth;
    }

    public function setHeigth(int $heigth): self
    {
        $this->heigth = $heigth;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getCleanPassword(): ?string
    {
        return $this->cleanPassword;
    }

    public function setCleanPassword(string $cleanPassword): self
    {
        $this->cleanPassword = $cleanPassword;

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
        }

        return $this;
    }

    public function removeIdweek(Week $idweek): self
    {
        $this->idweek->removeElement($idweek);

        return $this;
    }

    public function getRoles(){
        return ['ROLE_USER'];
    }

    public function getSalt(){

    }
    public function getUsername(){

    }
    public function eraseCredentials(){

    }

}
