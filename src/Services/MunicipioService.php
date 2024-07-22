<?php

namespace App\Services;
use App\Entity\Departamento;
use App\Repository\MunicipioRepository;

class MunicipioService
{
    public function __construct(private MunicipioRepository $repository)
    {
    }

    public function get_list_combo_select(Departamento $departamento): array
    {
        return $this->repository->get_format_combo_select($departamento);
    }

}
