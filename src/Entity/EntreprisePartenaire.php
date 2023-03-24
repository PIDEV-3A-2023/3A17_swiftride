<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;
/**
 * EntreprisePartenaire
 *
 * @ORM\Table(name="entreprise_partenaire", indexes={@ORM\Index(name="id_admin", columns={"id_admin"})})
 * @ORM\Entity
 */
class EntreprisePartenaire
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
     * @ORM\Column(name="nom_entreprise", type="string", length=50, nullable=false)
     */
    private $nomEntreprise;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_admin", type="string", length=50, nullable=false)
     */
    private $nomAdmin;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_admin", type="string", length=50, nullable=false)
     */
    private $prenomAdmin;

    /**
     * @var int
     *
     * @ORM\Column(name="nb_voiture", type="integer", nullable=false)
     */
    private $nbVoiture;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=12, nullable=false)
     */
    private $tel;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=25, nullable=false)
     */
    private $matricule;

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
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_admin", referencedColumnName="id")
     * })
     */
    private $idAdmin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEntreprise(): ?string
    {
        return $this->nomEntreprise;
    }

    public function setNomEntreprise(string $nomEntreprise): self
    {
        $this->nomEntreprise = $nomEntreprise;

        return $this;
    }

    public function getNomAdmin(): ?string
    {
        return $this->nomAdmin;
    }

    public function setNomAdmin(string $nomAdmin): self
    {
        $this->nomAdmin = $nomAdmin;

        return $this;
    }

    public function getPrenomAdmin(): ?string
    {
        return $this->prenomAdmin;
    }

    public function setPrenomAdmin(string $prenomAdmin): self
    {
        $this->prenomAdmin = $prenomAdmin;

        return $this;
    }

    public function getNbVoiture(): ?int
    {
        return $this->nbVoiture;
    }

    public function setNbVoiture(int $nbVoiture): self
    {
        $this->nbVoiture = $nbVoiture;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

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

    public function getIdAdmin(): ?Utilisateur
    {
        return $this->idAdmin;
    }

    public function setIdAdmin(?Utilisateur $idAdmin): self
    {
        $this->idAdmin = $idAdmin;

        return $this;
    }


}
