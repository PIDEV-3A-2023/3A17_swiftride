<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Materiel
 *
 * @ORM\Table(name="materiel", indexes={@ORM\Index(name="id_garage", columns={"id_garage"})})
 * @ORM\Entity
 */
class Materiel
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
     * @ORM\Column(name="nom", type="string", length=11, nullable=false)
     */
    private $nom;

    /**
     * @var \Garage
     *
     * @ORM\ManyToOne(targetEntity="Garage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_garage", referencedColumnName="id")
     * })
     */
    private $idGarage;

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

    public function getIdGarage(): ?Garage
    {
        return $this->idGarage;
    }

    public function setIdGarage(?Garage $idGarage): self
    {
        $this->idGarage = $idGarage;

        return $this;
    }


}
