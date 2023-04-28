<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonceRepository;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
class Annonces
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column(length:255)]
   #[Assert\NotBlank(message:" title est requis")]
   #[Assert\Length( 
    min: 3,
    minMessage: 'le title doit etre superieure au :  {{ limit }} caractéres')]
    private $title;

    #[ORM\Column(length:255)]
    #[Assert\NotBlank(message:" image est requis")]
    private $image;
    
    #[ORM\Column(length:65535)]
    #[Assert\NotBlank(message:"content est requis")]
    #[Assert\Length( 
        min: 5,
        max: 2555,
    minMessage: 'il faut etre superieure au :  {{ limit }} caractéres',
    maxMessage: 'il faut etre inferieur au :  {{ limit }} caractéres')]

    private $content;
    
    #[ORM\Column]
    private ?\DateTime  $dateannonce ;
    
    

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
    public function setContent(string $content): self
    {
        $this->content = $content;

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
    

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
    
    public function getDate(): ?\DateTime
    {
        return $this->dateannonce;
    }

    public function setDate(\DateTime $dateannonce): self
    {
        $this->dateannonce = $dateannonce;

        return $this;
    }
}
