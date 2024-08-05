<?php

namespace App\Services;

use App\ClassRequest\RequestPais;
use App\Entity\Pais;
use App\Repository\PaisRepository;


class PaisService
{
    public function __construct(
        private PaisRepository $repository
    ) {
    }



    public function get_list_combo_select(): array
    {
        return $this->repository->get_format_combo_select();
    }


    public function get_list_crud_pais(): array
    {
        return  $this->repository->list_crud();
    }

    public function crud_pais(RequestPais $requestPais): array
    {
        if ($requestPais->isDelete()) {
            $entity = $this->repository->findOneBy(['id' => $requestPais->getId()]);
            if ($entity instanceof Pais) {
                $entity->active();
                $this->repository->save($entity);
            }
        }


        if ($requestPais->isUpdate()) {
            $entity1 = $this->repository->findOneBy(['name' => $requestPais->getName()]);
            $entity2 = $this->repository->findOneBy(['id' => $requestPais->getId()]);
            if (!$entity1 instanceof Pais) {
                $entity2->setName($requestPais->getName());
                $this->repository->save($entity2);
            }
        }

        if ($requestPais->isCreate()) {
            $entity1 = $this->repository->findOneBy(['name' => $requestPais->getName()]);
            if (!$entity1 instanceof Pais) {
                $this->repository->save($requestPais->getEntity());         
            }
            if ($entity1 instanceof Pais) {
                $entity1->active();
                $this->repository->save($entity1);       
            }
        }


        return [];
    }
}
