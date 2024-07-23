<?php

namespace App\Services;

use App\Entity\Departamento;
use App\Entity\Pais;

class SelectService
{

    public function __construct(
        private PaisService $paisService,
        private DepartamentoService $departamentoService,
        private MunicipioService $municipioService
    ) {
    }

    public function getPaises(): array
    {
        $paises = $this->paisService->get_list_combo_select();
        return $this->unshift($paises);
    }

    public function getDepartamentos(Pais $pais): array
    {
        $departamentos = $this->departamentoService->get_list_combo_select($pais);
        return $this->unshift($departamentos);
    }
    
    public function getMunicipios(Departamento $departamento): array
    {
        $municipios = $this->municipioService->get_list_combo_select($departamento);
        return $this->unshift($municipios);
    }

    private function  unshift(array $array): array
    {
        array_unshift($array, ['id' => 0, 'name' => 'selecionar un campo']);
        return $array;
    }
}
