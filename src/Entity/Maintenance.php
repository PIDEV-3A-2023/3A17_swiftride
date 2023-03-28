<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaintenanceRepository;

#[ORM\Entity(repositoryClass: MaintenanceRepository::class)]
class Maintenance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column]
    private $dateMaintenance = 'CURRENT_TIMESTAMP';

    #[ORM\Column(length:25)]
    private $type;

    #[ORM\Column]
    private $finMaintenance = 'CURRENT_TIMESTAMP';

    #[ORM\ManyToOne(inversedBy:'maintenaces')]
    private $idGarage;

    #[ORM\ManyToOne(inversedBy:'maintenaces')]
    private $idVoiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateMaintenance(): ?\DateTimeInterface
    {
        return $this->dateMaintenance;
    }

    public function setDateMaintenance(\DateTimeInterface $dateMaintenance): self
    {
        $this->dateMaintenance = $dateMaintenance;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getFinMaintenance(): ?\DateTimeInterface
    {
        return $this->finMaintenance;
    }

    public function setFinMaintenance(\DateTimeInterface $finMaintenance): self
    {
        $this->finMaintenance = $finMaintenance;

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

    public function getIdVoiture(): ?Voiture
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(?Voiture $idVoiture): self
    {
        $this->idVoiture = $idVoiture;

        return $this;
    }



}
