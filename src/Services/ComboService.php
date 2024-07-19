<?php

namespace App\Services;

use App\Entity\Departamento;
use App\Entity\Pais;
use App\Repository\DepartamentoRepository;
use App\Repository\MunicipioRepository;
use App\Repository\PaisRepository;

class ComboService
{

    public function __construct(
        private PaisRepository $paisRepository,
        private DepartamentoRepository $departamentoRepository,
        private MunicipioRepository $municipioRepository
    ) {
    }

    public function getPaises(): array
    {
        $paises = $this->paisRepository->findAll();
        return $this->unshift($paises);
    }


    public function get_list_crud_pais(): array
    {
        return  $this->paisRepository->list_crud();
    }

    public function crud_pais(Pais $pais): array
    {
        if ($pais->isDelete()) {
            $entity = $this->paisRepository->findOneBy(['id' => $pais->getId()]);
            if ($entity instanceof Pais) {
                $entity->delete();
                $this->paisRepository->save($entity);
                return [];
            }
        }

        if ($pais->isUpdate()) {
            $entity = $this->paisRepository->findOneBy(['id' => $pais->getId()]);
            if ($entity instanceof Pais) {
                $entity->setName($pais->getName());
                $this->paisRepository->save($entity);
                return [];
            }
        }

        $pais->isCreate() &&  $this->paisRepository->save($pais);

        return [];
    }



    public function getDepartamentos(Pais $pais): array
    {
        $departamentos = $this->departamentoRepository->findAllByPais($pais);
        return $this->unshift($departamentos);
    }

    public function getMunicipios(Departamento $departamento): array
    {
        $municipios = $this->municipioRepository->findAllByDepartamento($departamento);
        return $this->unshift($municipios);
    }

    private function  unshift(array $array): array
    {
        array_unshift($array, ['id' => 0, 'name' => 'selecionar un campo']);
        return $array;
    }

    /**crud de combos */
}
