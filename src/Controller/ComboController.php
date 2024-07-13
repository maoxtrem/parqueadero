<?php

namespace App\Controller;

use App\Services\ComboService;
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
    public function pais(ComboService $comboService): JsonResponse
    {
        $paises = $comboService->getPaises();
        return new JsonResponse($paises);
    }
    
    #[Route('/combo/depto', name: 'app_combo_depto')]
    public function depto(RequestService $request): JsonResponse
    {
        $id = $request->get('id');


        if ($id == 1) {
            $array = [];
            for ($i = 1; $i < 10000; $i++) {
                array_push($array, ['id' => $i, 'name' => 'item_' . $i]);
            }
            array_unshift($array, ['id' => 0, 'name' => 'selecionar un campo']);
            return new JsonResponse($array);
        }

        if ($id == 2) {
            return new JsonResponse([
                ['id' => 0, 'name' => 'selecionar un campo'],
                ['id' => 1, 'name' => 'armenia'],
                ['id' => 2, 'name' => 'bucaranago']
            ]);
        }

        return new JsonResponse([['id' => 0, 'name' => 'selecionar un campo']]);
    }
}
