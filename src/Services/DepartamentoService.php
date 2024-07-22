<?php

namespace App\Services;

use App\ClassRequest\RequestDepartamento;
use App\Entity\Departamento;
use App\Entity\Pais;
use App\Repository\DepartamentoRepository;

class DepartamentoService
{

    public function __construct(private DepartamentoRepository $repository)
    {
    }



    public function get_list_combo_select(Pais $pais): array
    {
        return $this->repository->get_format_combo_select($pais);
    }



    public function get_list_crud_departamento(): array
    {
        return  $this->repository->list_crud();
    }


    public function crud_departamento(RequestDepartamento $requestDepartamento): array
    {

        if ($requestDepartamento->isCreate()) {
            $entity = $this->repository->findOneBy([
                'pais' => $requestDepartamento->getIdPais(),
                'name' => $requestDepartamento->getName()
            ]);
            if ($entity instanceof Departamento) {
                if (!$entity->isActive()) {
                    $entity->active();
                    $this->repository->save($entity);
                }
                return [];
            }

            $this->repository->save($requestDepartamento->getEntity());

            return [];
        }

        if ($requestDepartamento->isUpdate()) {
            $entity = $this->repository->findOneBy(['id' => $requestDepartamento->getId()]);
            $entity1 = $this->repository->findOneBy([
                'pais' => $requestDepartamento->getIdPais(),
                'name' => $requestDepartamento->getName()
            ]);

            if (!$entity instanceof Departamento) {
                return [];
            }
            if ($entity1 instanceof Departamento) {
                return [];
            }

            $entity->setName($requestDepartamento->getName());
            $entity->setPais($requestDepartamento->getEntity()->getPais());
            $this->repository->save($entity);
            return [];
        }


        if ($requestDepartamento->isDelete()) {
            $entity = $this->repository->findOneBy(['id' => $requestDepartamento->getId()]);
            if ($entity instanceof Departamento) {
                $entity->active();
                $this->repository->save($entity);
            }
        }

        return [];
    }
}
