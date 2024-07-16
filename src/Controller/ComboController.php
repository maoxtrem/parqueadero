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

    #[Route('/pais', name: 'pais')]
    public function pais(ComboService $comboService): JsonResponse
    {
        $paises = $comboService->getPaises();
        return new JsonResponse($paises);
    }

    #[Route('/departamento', name: 'departamento')]
    public function departamento(RequestService $request, ComboService $comboService): JsonResponse
    {
        $pais = $request->getPais();
        $departamentos=$comboService->getDepartamentos($pais);
        return new JsonResponse($departamentos);
    }

    #[Route('/municipio', name: 'municipio')]
    public function municipio(RequestService $request, ComboService $comboService): JsonResponse
    {
        $departamento = $request->getDepartamento();
        $municipios=$comboService->getMunicipios($departamento);
        return new JsonResponse($municipios);
    }
}
