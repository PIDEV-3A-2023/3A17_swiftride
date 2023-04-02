<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\EntreprisePartenaireRepository;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: EntreprisePartenaireRepository::class)]
class EntreprisePartenaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column]
private ?string $nom_entreprise = null;

    public function getNomEntreprise(): ?string
    {
        return $this->nom_entreprise;
    }

    public function setNomEntreprise(string $nom_entreprise): self
    {
         $this->nom_entreprise = $nom_entreprise;

         return $this;  
    }

    #[ORM\Column]
    private ?string $nom_admin = null;

    public function getNomAdmin(): ?string
    {
        return $this->nom_admin;
    }

    public function setNomAdmin(string $nom_admin): self
    {
         $this->nom_admin = $nom_admin;

         return $this;  
    }
    
    #[ORM\Column]
    private ?string $prenom_admin = null;

    public function getPrenomAdmin(): ?string
    {
        return $this->prenom_admin;
    }

    public function setPrenomAdmin(string $prenom_admin): self
    {
         $this->prenom_admin = $prenom_admin;

         return $this;  
    }    

    #[ORM\Column]
    private ?int $nb_voiture = null;

    public function getNbVoiture(): ?string
    {
        return $this->nb_voiture;
    }

    public function setNbVoiture(string $nb_voiture): self
    {
         $this->nb_voiture = $nb_voiture;

         return $this;  
    }     

    #[ORM\Column]
    private ?int $tel = null;

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
         $this->tel = $tel;

         return $this;  
    } 

    #[ORM\Column]
    private ?string $matricule = null;

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
         $this->matricule = $matricule;

         return $this;  
    }  

    #[ORM\Column]
    private ?string $login = null;

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
         $this->login = $login;

         return $this;  
    }  

    #[ORM\Column]
    private ?string $mdp = null;

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
         $this->mdp = $mdp;

         return $this;  
    }  

    #[ORM\Column]
    private ?string $id_admin = null;

    public function getIdAdmin(): ?string
    {
        return $this->id_admin;
    }

    public function setIdAdmin(string $id_admin): self
    {
         $this->id_admin = $id_admin;

         return $this;  
    }  


}




    


