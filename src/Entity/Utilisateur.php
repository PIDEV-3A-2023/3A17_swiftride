<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:35)]
    private $nom;

    #[ORM\Column(length:35)]
    private $prenom;

    #[ORM\Column(length:12)]
    private $cin;

    #[ORM\Column(length:255)]
    private $dateNaiss;

    #[ORM\Column(length:255)]
    private $age;

    #[ORM\Column(length:12)]
    private $numPermis;

    #[ORM\Column(length:40)]
    private $ville;

    #[ORM\Column(length:12)]
    private $numTel;

    #[ORM\Column(length:255)]
    private $login;

    #[ORM\Column(length:255)]
    private $mdp;

    #[ORM\Column(length:255)]
    private $photoPersonel;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'sender')]
    private Collection $sentMessages;
    
    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: 'recipient')]
    private Collection $receivedMessages;
    
   
    
    #[ORM\Column(length:255)]
    private $photoPermis;
    
    public function __construct() {
        $this->sentMessages = new ArrayCollection();
        $this->receivedMessages = new ArrayCollection();
     }
     
     public function getSentMessages(): Collection {
         return $this->sentMessages;
     }
     
     public function getReceivedMessages(): Collection {
         return $this->receivedMessages;
     }
     public function addSentMessage(Message $sentMessage): self
     {
         if (!$this->sentMessages->contains($sentMessage)) {
             $this->sentMessages[] = $sentMessage;
             $sentMessage->setSender($this);
         }
 
         return $this;
     }
 
     public function removeSentMessage(Message $sentMessage): self
     {
         if ($this->sentMessages->removeElement($sentMessage)) {
             // set the owning side to null (unless already changed)
             if ($sentMessage->getSender() === $this) {
                 $sentMessage->setSender(null);
             }
         }
 
         return $this;
     }
 
     
 
     public function addReceivedMessage(Message $receivedMessage): self
     {
         if (!$this->receivedMessages->contains($receivedMessage)) {
             $this->receivedMessages[] = $receivedMessage;
             $receivedMessage->setRecipient($this);
         }
 
         return $this;
     }
 
     public function removeReceivedMessage(Message $receivedMessage): self
     {
         if ($this->receivedMessages->removeElement($receivedMessage)) {
             // set the owning side to null (unless already changed)
             if ($receivedMessage->getRecipient() === $this) {
                 $receivedMessage->setRecipient(null);
             }
         }
 
         return $this;
     }
    public function getId(): ?string
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

   


}
