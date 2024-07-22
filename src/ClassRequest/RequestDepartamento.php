<?php

namespace App\ClassRequest;

use App\Entity\Departamento;
use App\Repository\PaisRepository;

class RequestDepartamento extends RequestCRUD
{


    private ?string $name;
    private ?int $id_pais;

    public function __construct(private PaisRepository $paisRepository)
    {
    }

    public function getEntity(): Departamento
    {
        $pais = $this->paisRepository->findOneBy(['id' => $this->id_pais]);
        $entity = new Departamento;
        $entity->setName($this->name);
        $entity->setPais($pais);
        return $entity;
    }



    public function getIdPais(): int
    {
        return $this->id_pais;
    }


    public function setIdPais(?int $id_pais): self
    {
        $this->id_pais = $id_pais;

        return $this;
    }


    public function getName(): ?string
    {
        return $this->name;
    }


    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
