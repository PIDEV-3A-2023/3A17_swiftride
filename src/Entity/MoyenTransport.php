<?php

namespace App\Entity;

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
    

    public function getId(): ?int
    {
        return $this->id;
    }

    #[ORM\Column]
private ?string $type = null;

public function getType(): ?string
{
    return $this->type;
}

public function setType(string $type): self
{
    $this->type = $type;

    return $this;
}

   #[ORM\Column]

    private ?int $numero_trans = null;

public function getNumeroTrans(): ?int
{
return $this->numero_trans;
}

public function setNumeroTrans(int $numero_trans): self
{
$this->numero_trans = $numero_trans;
return $this;
}
}