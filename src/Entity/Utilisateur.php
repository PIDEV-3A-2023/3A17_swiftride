<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Role;
use App\Repository\UtilisateurRepository;
use DateTime;
use PhpParser\Node\Name;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints As Assert;
#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\Column]
    #[ORM\GeneratedValue()]
    private ?int $id=null;


    #[Assert\NotBlank(message:"Ce champs est vide")]
    //#[Assert\Length(min:4 , message : "Au minimum 4 caractéres{{limit}}")]
    #[ORM\Column(length:50)]
    private ?string $nom=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    //#[Assert\Length(min:8,message:"Au minimum 8 caractéres.")]
    #[ORM\Column(length:50)]

    private ?string $prenom=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    //#[Assert\Length(exactly:8,message:"il faut 8 chiffres")]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]
    #[ORM\Column(length:50)]
    private ?string $cin=null;
    
    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[ORM\Column(length:255)]
    private ?\DateTime $date_naiss=null;

    #[ORM\Column(length:50)]
    private ?string $age=null; 


    #[Assert\NotBlank(message:"Ce champs est vide")]
    //#[Assert\Length(exactly:8, message:"il faut 8 chiffres")]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]
    #[ORM\Column(length:50)]
    private ?string $num_permis=null;

    #[ORM\Column(length:50)]
    private ?string $ville=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    //#[Assert\Length(exactly:8,message:"il faut 8 chiffres")]
    #[Assert\Regex(pattern:"/^[0-9]+$/", message:"Contient seulement des chiffres.")]

    #[ORM\Column(length:50)]
    private ?string $num_tel=null;

    #[Assert\NotBlank(message:"Ce champs est vide")]
    #[Assert\Email(message:"La format de l'email est non valide")]
    #[ORM\Column(length:255)]
    private ?string $login=null;

   // #[Assert\Length(min:10,message:"Votre mot de passe ne contient pas 10 caractères.")]
   #[ORM\Column(length:50)]
   private ?string $mdp=null;

    #[ORM\Column(length:50)]
    private ?string $photo_personel=null;

    #[ORM\Column(length:50)]
    private ?string $photo_permis=null;
    #[ORM\JoinColumn(name: 'idrole', referencedColumnName: 'id')]
    #[ORM\OneToOne(targetEntity: Role::class )]
    private ?Role $idrole = null;
    
public function setId(int $id){
    $this->id = $id;
    return $this;
}

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

public function getDateNaiss(): ?\DateTimeInterface
{
    return $this->date_naiss;
}

public function setDateNaiss(\DateTimeInterface $date_naiss): self
{
    $this->date_naiss = $date_naiss;

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
    return $this->num_permis;
}

public function setNumPermis(string $num_permis): self
{
    $this->num_permis = $num_permis;

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
    return $this->num_tel;
}

public function setNumTel(string $num_tel): self
{
    $this->num_tel = $num_tel;

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
    return $this->photo_personel;
}

public function setPhotoPersonel(string $photo_personel): self
{
    $this->photo_personel = $photo_personel;

    return $this;
}

public function getPhotoPermis(): ?string
{
    return $this->photo_permis;
}

public function setPhotoPermis(string $photo_permis): self
{
    $this->photo_permis = $photo_permis;

    return $this;
}

public function getIdrole(): ?Role
{
    return $this->idrole;
}

public function setIdrole(?Role $idrole): self
{
    $this->idrole = $idrole;

    return $this;
}



}
