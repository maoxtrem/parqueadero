<?php

namespace App\Services;

use App\ClassRequest\RequestMunicipio;
use App\Entity\Departamento;
use App\Entity\Municipio;
use App\Repository\MunicipioRepository;

class MunicipioService
{
    public function __construct(
        private MunicipioRepository $repository,
        
        )
    {
    }

    public function get_list_combo_select(Departamento $departamento): array
    {
        return $this->repository->get_format_combo_select($departamento);
    }

    public function get_list_crud_municipio(): array
    {
        return  $this->repository->list_crud();
    }


    public function crud_municipio(RequestMunicipio $requestMunicipio): array
    {

        if ($requestMunicipio->isCreate()) {
            $entity = $this->repository->findOneBy([
                'departamento' => $requestMunicipio->getIdDepartamento(),
                'name' => $requestMunicipio->getName()
            ]);
            if ($entity instanceof Municipio) {
                if (!$entity->isActive()) {
                    $entity->active();
                    $this->repository->save($entity);
                }
                return [];
            }
            $this->repository->save($requestMunicipio->getEntity());

            return [];
        }

        if ($requestMunicipio->isUpdate()) {
            $entity = $this->repository->findOneBy(['id' => $requestMunicipio->getId()]);
            $entity1 = $this->repository->findOneBy([
                'departamento' => $requestMunicipio->getIdDepartamento(),
                'name' => $requestMunicipio->getName()
            ]);

            if (!$entity instanceof Municipio) {
                return [];
            }
            if ($entity1 instanceof Municipio) {
                return [];
            }

            $entity->setName($requestMunicipio->getName());
            $entity->setDepartamento($requestMunicipio->getEntity()->getDepartamento());
            $this->repository->save($entity);
            return [];
        }


        if ($requestMunicipio->isDelete()) {
            $entity = $this->repository->findOneBy(['id' => $requestMunicipio->getId()]);
            if ($entity instanceof Municipio) {
                $entity->active();
                $this->repository->save($entity);
            }
        }

        return [];
    }
}
