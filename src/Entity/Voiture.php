<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Voiture
 *
 * @ORM\Table(name="voiture", indexes={@ORM\Index(name="id_entreprise_partenaire", columns={"id_entreprise_partenaire"}), @ORM\Index(name="id_voiture", columns={"id_utilisateur"})})
 * @ORM\Entity
 */
class Voiture
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
     * @ORM\Column(name="CarteGrise", type="string", length=255, nullable=false)
     */
    private $cartegrise;

    /**
     * @var string
     *
     * @ORM\Column(name="marque", type="string", length=40, nullable=false)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=40, nullable=false)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="etat", type="string", length=20, nullable=false)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(name="couleur", type="string", length=20, nullable=false)
     */
    private $couleur;

    /**
     * @var string
     *
     * @ORM\Column(name="etat_technique", type="string", length=25, nullable=false)
     */
    private $etatTechnique;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=50, nullable=false)
     */
    private $matricule;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_circulation", type="date", nullable=false)
     */
    private $dateCirculation;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="Kilometrage", type="integer", nullable=false)
     */
    private $kilometrage;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=255, nullable=false)
     */
    private $position;

    /**
     * @var \EntreprisePartenaire
     *
     * @ORM\ManyToOne(targetEntity="EntreprisePartenaire")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_entreprise_partenaire", referencedColumnName="id")
     * })
     */
    private $idEntreprisePartenaire;

    /**
     * @var \Utilisateur
     *
     * @ORM\ManyToOne(targetEntity="Utilisateur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_utilisateur", referencedColumnName="id")
     * })
     */
    private $idUtilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCartegrise(): ?string
    {
        return $this->cartegrise;
    }

    public function setCartegrise(string $cartegrise): self
    {
        $this->cartegrise = $cartegrise;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getEtatTechnique(): ?string
    {
        return $this->etatTechnique;
    }

    public function setEtatTechnique(string $etatTechnique): self
    {
        $this->etatTechnique = $etatTechnique;

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

    public function getDateCirculation(): ?\DateTimeInterface
    {
        return $this->dateCirculation;
    }

    public function setDateCirculation(\DateTimeInterface $dateCirculation): self
    {
        $this->dateCirculation = $dateCirculation;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getIdEntreprisePartenaire(): ?EntreprisePartenaire
    {
        return $this->idEntreprisePartenaire;
    }

    public function setIdEntreprisePartenaire(?EntreprisePartenaire $idEntreprisePartenaire): self
    {
        $this->idEntreprisePartenaire = $idEntreprisePartenaire;

        return $this;
    }

    public function getIdUtilisateur(): ?Utilisateur
    {
        return $this->idUtilisateur;
    }

    public function setIdUtilisateur(?Utilisateur $idUtilisateur): self
    {
        $this->idUtilisateur = $idUtilisateur;

        return $this;
    }


}
