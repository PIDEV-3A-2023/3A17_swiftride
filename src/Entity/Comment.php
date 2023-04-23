<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="comments")
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

/**
 * @ORM\ManyToOne(targetEntity="App\Entity\EntreprisePartenaire", inversedBy="commentaires")
 * @ORM\JoinColumn(nullable=false)
 */
private $entreprisePartenaire;

    /**
     * @ORM\Column(type="string")
     */
    private $commentaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEntreprisePartenaire(): ?EntreprisePartenaire
    {
        return $this->entreprisePartenaire;
    }
    
    public function setEntreprisePartenaire(?EntreprisePartenaire $entreprisePartenaire): self
    {
        $this->entreprisePartenaire = $entreprisePartenaire;
        return $this;
    }
    

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    
}
