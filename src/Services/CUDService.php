<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class CUDService{


    public function __construct(
        private RequestService $request,
        private PaisService $paisService,
        private DepartamentoService $departamentoService,
        private MunicipioService $municipioService

    ) {
    }

    public function pais() : JsonResponse {
        $pais = $this->request->getPaisCrud();
        $this->paisService->crud_pais($pais);
        return new JsonResponse([]);
    }

    public function departamento() : JsonResponse {
        $departamento = $this->request->getDepartamentoCrud();
        $this->departamentoService->crud_departamento($departamento);
        return new JsonResponse([]);
    }

    public function municipio() : JsonResponse {
   
        $municipio = $this->request->getMunicipioCrud();
        $this->municipioService->crud_municipio($municipio);
        return new JsonResponse([]);
    }
}