<?php

namespace App\Controller;

use App\Services\ComboService;
use App\Services\DepartamentoService;
use App\Services\PaisService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\RequestService;
use App\Services\UserService;

#[Route('/combo', name: 'app_combo_')]
class ComboController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('combo.html.twig');
    }

    /**
     * lista de data para select
     */

    #[Route('/pais', name: 'paises')]
    public function paises(ComboService $comboService): JsonResponse
    {
        $paises = $comboService->getPaises();
        return new JsonResponse($paises);
    }

    #[Route('/departamento', name: 'departamentos')]
    public function departamentos(RequestService $request, ComboService $comboService): JsonResponse
    {
        $pais = $request->getPais();
        $departamentos = $comboService->getDepartamentos($pais);
        return new JsonResponse($departamentos);
    }

    #[Route('/municipio', name: 'municipios')]
    public function municipios(RequestService $request, ComboService $comboService): JsonResponse
    {
        $departamento = $request->getDepartamento();
        $municipios = $comboService->getMunicipios($departamento);
        return new JsonResponse($municipios);
    }

    /**
     * crud de combos
     */

    #[Route('/list_crud_pais', name: 'list_crud_pais')]
    public function crud_list_pais(PaisService $paisService): JsonResponse
    {
        $paises = $paisService->get_list_crud_pais();
        return new JsonResponse($paises);
    }

    #[Route('/crud_pais', name: 'crud_pais')]
    public function crud_pais(RequestService $request, PaisService $paisService): JsonResponse
    {
        $pais = $request->getPaisCrud();
        $paisService->crud_pais($pais);
        return new JsonResponse([]);
    }

    #[Route('/list_crud_departamento', name: 'list_crud_departamento')]
    public function crud_list_departamento(DepartamentoService $departamentoService): JsonResponse
    {
        $departamentos = $departamentoService->get_list_crud_departamento();
        return new JsonResponse($departamentos);
    }

    #[Route('/crud_departamento', name: 'crud_departamento')]
    public function crud_departamento(RequestService $request, DepartamentoService $departamentoService): JsonResponse
    {
        $departamento = $request->getDepartamentoCrud();
        $departamentoService->crud_departamento($departamento);
        return new JsonResponse([]);
    }
}
