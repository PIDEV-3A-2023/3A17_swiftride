<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private $id;

    #[ORM\Column]
    private $etat;

    #[ORM\Column]
    private $contenu;

    #[ORM\Column]
    private $envoyerAt = 'CURRENT_TIMESTAMP';

  
    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(name: 'idutilisateur', referencedColumnName: 'id')]
    private $idutilisateur;

   
    #[ORM\ManyToOne(targetEntity: EntreprisePartenaire::class)]
    #[ORM\JoinColumn(name: 'identreprise', referencedColumnName: 'id')]
    private $identreprise;


}
