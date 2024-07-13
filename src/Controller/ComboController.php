<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Services\RequestService;

class ComboController extends AbstractController
{
    #[Route('/combo', name: 'app_combo')]
    public function index(): Response
    {
        return $this->render('combo/index.html.twig');
    }

    #[Route('/combo/pais', name: 'app_combo_pais')]
    public function pais(): JsonResponse
    {
        return new JsonResponse([
            ['id' => 1, 'name' => 'colombia'],
            ['id' => 2, 'name' => 'peru'],
            ['id' => 3, 'name' => 'venezuela'],
            ['id' => 4, 'name' => 'panama']
        ]);
    }
    #[Route('/combo/depto', name: 'app_combo_depto')]
    public function depto(RequestService $request): JsonResponse
    {
        $id = $request->get('id');


        if ($id == 1) {
            return new JsonResponse([
                ['id' => 1, 'name' => 'barranca'],
                ['id' => 2, 'name' => 'bogota']
            ]);
        }

        if ($id == 2) {
            return new JsonResponse([
                ['id' => 1, 'name' => 'armenia'],
                ['id' => 2, 'name' => 'bucaranago']
            ]);
        }

        return new JsonResponse([]);
    }
}
