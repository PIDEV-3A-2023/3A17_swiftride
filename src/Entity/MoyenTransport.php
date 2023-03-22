<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MoyenTransport
 *
 * @ORM\Table(name="moyen_transport")
 * @ORM\Entity
 */
class MoyenTransport
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=25, nullable=false)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="numero_trans", type="integer", nullable=false)
     */
    private $numeroTrans;

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
        return $this->numeroTrans;
    }

    public function setNumeroTrans(int $numeroTrans): self
    {
        $this->numeroTrans = $numeroTrans;

        return $this;
    }


}
