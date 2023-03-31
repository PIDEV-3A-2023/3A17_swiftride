<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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


    #[ORM\Column(length:255)]
    private $photoPermis;

   


}
