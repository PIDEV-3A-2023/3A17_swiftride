<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\MoyenTransportRepository;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: MoyenTransportRepository::class)]
class MoyenTransport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\Column]
    
    private ?string $type = null;


   #[ORM\Column]

    private ?int $numero_trans = null;

   #[ORM\ManyToMany(targetEntity: Station::class)]
   private Collection $MoyenStation;

   public function __construct()
   {
       $this->MoyenStation = new ArrayCollection();
   }


   public function getId(): ?int
   {
       return $this->id;
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


    public function getNumeroTrans(): ?int
    {
    return $this->numero_trans;
    }

    public function setNumeroTrans(int $numero_trans): self
    {
    $this->numero_trans = $numero_trans;
    return $this;
    }

    /**
     * @return Collection<int, Station>
     */
    public function getMoyenStation(): Collection
    {
        return $this->MoyenStation;
    }

    public function addMoyenStation(Station $moyenStation): self
    {
        if (!$this->MoyenStation->contains($moyenStation)) {
            $this->MoyenStation->add($moyenStation);
        }

        return $this;
    }

    public function removeMoyenStation(Station $moyenStation): self
    {
        $this->MoyenStation->removeElement($moyenStation);

        return $this;
    }
    }
   

   