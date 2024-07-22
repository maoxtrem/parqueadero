<?php

namespace App\ClassRequest;

use App\Entity\Municipio;
use App\Repository\DepartamentoRepository;

class RequestMunicipio extends RequestCRUD
{


    private ?string $name;
    private ?int $id_departamento;

    public function __construct(private DepartamentoRepository $departamentoRepository)
    {
    }

    public function getEntity(): Municipio
    {
        $departamento = $this->departamentoRepository->findOneBy(['id' => $this->id_departamento]);
        $entity = new Municipio;
        $entity->setName($this->name);
        $entity->setDepartamento($departamento);
        return $entity;
    }



    public function getIdDepartamento(): int
    {
        return $this->id_departamento;
    }


    public function setIdDepartamento(?int $id_departamento): self
    {
        $this->id_departamento = $id_departamento;

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
