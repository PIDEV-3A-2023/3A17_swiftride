<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:255)]
    private $tilte;

    #[ORM\Column(length:65535)]

    private $message;

    #[ORM\Column]
    private ?\DateTime $createdAt ;

    #[ORM\Column(type: 'boolean')]
    private bool $is_read = false;
    
 
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'sender_id', referencedColumnName: 'id')]
    private $sender;
   
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'recipient_id', referencedColumnName: 'id')]
    private $recipient;
    public function getId(): ?string
    {
        return $this->id;
    }
   
    
    public function __construct() {
       $this->createdAt = new \DateTime();
    }
    
    public function getTilte(): ?string
    {
        return $this->tilte;
    }

    public function setTilte(string $tilte): self
    {
        $this->tilte = $tilte;

        return $this;
    }

    

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getIsRead(): bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): self
    {
        $this->is_read = $is_read;

        return $this;
    }

 
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getSender(): ?Utilisateur
    {
        return $this->sender;
    }

    public function setSender(?Utilisateur $sender): self
    {
        $this->sender = $sender;

        return $this;
    }
    public function getRecipient(): ?Utilisateur
    {
        return $this->recipient;
    }

    public function setRecipient(?Utilisateur $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }


}
