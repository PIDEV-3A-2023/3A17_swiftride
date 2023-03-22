<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garage
 *
 * @ORM\Table(name="garage")
 * @ORM\Entity
 */
class Garage
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
     * @ORM\Column(name="matricule_garage", type="string", length=40, nullable=false)
     */
    private $matriculeGarage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatriculeGarage(): ?string
    {
        return $this->matriculeGarage;
    }

    public function setMatriculeGarage(string $matriculeGarage): self
    {
        $this->matriculeGarage = $matriculeGarage;

        return $this;
    }


}
