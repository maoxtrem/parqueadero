<?php

namespace App\Services;

use App\Repository\PaisRepository;

class ComboService
{

    public function __construct(private PaisRepository $paisRepository)
    {
    }

    public function getPaises(): array
    {
        $paises = $this->paisRepository->findAll();
        return $this->unshift($paises);
    }


    private function  unshift(array $array): array
    {
        array_unshift($array, ['id' => 0, 'name' => 'selecionar un campo']);
        return $array;
    }
}
