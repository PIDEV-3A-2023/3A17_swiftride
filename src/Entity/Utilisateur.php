<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Role;
/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur", indexes={@ORM\Index(name="fk", columns={"idrole"})})
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=35, nullable=false)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=35, nullable=false)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=12, nullable=false)
     */
    private $cin;

    /**
     * @var string
     *
     * @ORM\Column(name="date_naiss", type="string", length=255, nullable=false)
     */
    private $dateNaiss;

    /**
     * @var string
     *
     * @ORM\Column(name="age", type="string", length=255, nullable=false)
     */
    private $age;

    /**
     * @var string
     *
     * @ORM\Column(name="num_permis", type="string", length=12, nullable=false)
     */
    private $numPermis;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=40, nullable=false)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="num_tel", type="string", length=12, nullable=false)
     */
    private $numTel;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp", type="string", length=255, nullable=false)
     */
    private $mdp;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_personel", type="string", length=255, nullable=false)
     */
    private $photoPersonel;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_permis", type="string", length=255, nullable=false)
     */
    private $photoPermis;

    /**
     * @var int
     *
     * @ORM\OneToOne(targetEntity="Role")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idrole", referencedColumnName="id")
     * })
     */
    #[ORM\OneToOne(mappedBy: 'id', targetEntity: Role::class)]
    private $idrole;
    
public function setId(int $id){
    $this->id = $id;
    return $this;
}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getDateNaiss(): ?string
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(string $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNumPermis(): ?string
    {
        return $this->numPermis;
    }

    public function setNumPermis(string $numPermis): self
    {
        $this->numPermis = $numPermis;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNumTel(): ?string
    {
        return $this->numTel;
    }

    public function setNumTel(string $numTel): self
    {
        $this->numTel = $numTel;

        return $this;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function getPhotoPersonel(): ?string
    {
        return $this->photoPersonel;
    }

    public function setPhotoPersonel(string $photoPersonel): self
    {
        $this->photoPersonel = $photoPersonel;

        return $this;
    }

    public function getPhotoPermis(): ?string
    {
        return $this->photoPermis;
    }

    public function setPhotoPermis(string $photoPermis): self
    {
        $this->photoPermis = $photoPermis;

        return $this;
    }

    public function getIdrole(): ?int
    {
       
        return $this->idrole;
    }

    public function setIdrole(?int $idrole): self
    {
        $this->idrole = $idrole;

        return $this;
    }


}
