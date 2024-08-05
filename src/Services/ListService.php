<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class ListService
{

    public function __construct(
        private SelectService $selectService,
        private RequestService $request,
        private PaisService $paisService,
        private DepartamentoService $departamentoService,
        private MunicipioService $municipioService

    ) {
    }

    public function select_paises(): JsonResponse
    {
        $paises = $this->selectService->getPaises();
        return new JsonResponse($paises);
    }

    public function select_departamentos(): JsonResponse
    {
        $pais = $this->request->getPais();
        $departamentos = $this->selectService->getDepartamentos($pais);
        return new JsonResponse($departamentos);
    }

    public function select_municipios(): JsonResponse
    {
        $departamento = $this->request->getDepartamento();
        $municipios = $this->selectService->getMunicipios($departamento);
        return new JsonResponse($municipios);
    }

    public function crud_paises(): JsonResponse
    {
        $paises = $this->paisService->get_list_crud_pais();
        return new JsonResponse($paises);
    }

    public function crud_departamentos(): JsonResponse
    {
        $departamentos = $this->departamentoService->get_list_crud_departamento();
        return new JsonResponse($departamentos);
    }


    public function crud_municipios(): JsonResponse
    {
        $requestPagination = $this->request->getPagination();
        $resultPagination = $this->municipioService->get_list_crud_municipio($requestPagination);
        return new JsonResponse($resultPagination->getResult());
    }



}
