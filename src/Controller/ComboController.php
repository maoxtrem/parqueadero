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

        $array = [];

        for ($i = 1; $i < 32; $i++) {
            array_push($array, ['id' => $i, 'name' => 'item_' . $i]);
        }



        return new JsonResponse($array);
    }
    #[Route('/combo/depto', name: 'app_combo_depto')]
    public function depto(RequestService $request): JsonResponse
    {
        $id = $request->get('id');


        if ($id == 1) {
            $array = [];
            for ($i = 1; $i < 100; $i++) {
                array_push($array, ['id' => $i, 'name' => 'item_' . $i]);
            }
            return new JsonResponse($array);
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
