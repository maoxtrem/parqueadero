<?php

namespace App\Controller;

use App\Services\ComboService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Services\RequestService;

#[Route('/combo', name: 'app_combo_')]
class ComboController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {

        return $this->render('combo/index.html.twig');
    }

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


    #[Route('/list_crud_pais', name: 'list_crud_pais')]
    public function crud_list_pais(ComboService $comboService): JsonResponse
    {
        $paises = $comboService->get_list_crud_pais();
        return new JsonResponse($paises); 
   
    }

    #[Route('/crud_pais', name: 'crud_pais')]
    public function crud_pais(RequestService $request, ComboService $comboService): JsonResponse
    {
       $pais = $request->getPaisCrud();
        return new JsonResponse([]);
    }


}
