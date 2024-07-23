<?php

namespace App\Controller;


use App\Services\CUDService;
use App\Services\ListService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



#[Route('/select/crud/', name: 'app_select_crud_')]
class SelectController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    #[Route('index', name: 'index')]
    public function index(): Response
    {
        return $this->render('combo.html.twig');
    }


    #[Route('/list_paises', name: 'list_paises')]
    public function crud_list_paises(ListService $list): JsonResponse
    {
       return $list->crud_paises();
    }

    #[Route('/pais', name: 'pais')]
    public function crud_pais(CUDService $cud): JsonResponse
    {
        return $cud->pais();
    }

    #[Route('/list_departamentos', name: 'list_departamentos')]
    public function crud_list_departamentos(ListService $list): JsonResponse
    {
        return $list->crud_departamentos();
    }

    #[Route('/departamento', name: 'departamento')]
    public function crud_departamento(CUDService $cud): JsonResponse
    {
        return $cud->departamento();
    }

    #[Route('/list_municipios', name: 'list_municipios')]
    public function crud_list_municipios(ListService $list): JsonResponse
    {
        return $list->crud_municipios();
    }

    #[Route('/municipio', name: 'municipio')]
    public function crud_municipio(CUDService $cud): JsonResponse
    {
        return $cud->municipio();
    }
}