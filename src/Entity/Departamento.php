<?php

namespace App\Entity;

use App\Repository\DepartamentoRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Trait\EntityTrait;

#[ORM\Entity(repositoryClass: DepartamentoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Departamento
{
    use EntityTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?Pais $pais = null;

    public function __construct(?int $id = null)
    {
        $this->id = $id;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPais(): ?Pais
    {
        return $this->pais;
    }

    public function setPais(?Pais $pais): static
    {
        $this->pais = $pais;

        return $this;
    }
}
