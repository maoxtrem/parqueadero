<?php

namespace App\Controller;



use App\Services\ListService;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/select', name: 'app_select_')]
class SelectListController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('/paises', name: 'paises')]
    public function paises(ListService $list): JsonResponse
    {
        return $list->select_paises();
    }

    #[Route('/departamentos', name: 'departamentos')]
    public function departamentos(ListService $list): JsonResponse
    {
        return $list->select_departamentos();
    }

    #[Route('/municipios', name: 'municipios')]
    public function municipios(ListService $list): JsonResponse
    {
        return $list->select_municipios();
    }
}