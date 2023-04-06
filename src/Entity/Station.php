<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Station
{
    #[ORM\Id]
    #[ORM\Column(name: "ids", type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private ?int $ids = null;
    
    #[ORM\Column(name: "ville", type: "string", length: 255)]
    private ?string $ville = null;
    
    #[ORM\Column(name: "nom_station", type: "string", length: 255)]
    private ?string $nomStation = null;

    public function getIds(): ?int
    {
        return $this->ids;
    }
    
    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getNomStation(): ?string
    {
        return $this->nomStation;
    }

    public function setNomStation(?string $nomStation): self
    {
        $this->nomStation = $nomStation;

        return $this;
    }
}
