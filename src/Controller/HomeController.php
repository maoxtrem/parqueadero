<?php

namespace App\Controller;

use App\Services\RequestService;
use App\Services\UserService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_home_')]
class HomeController extends AbstractController
{
    #[Route('home', name: 'index')]
    public function home(): Response
    {
 
        return $this->render('home.html.twig');
    }

    #[Route('users', name: 'list_users')]
    public function list(RequestService $requestService, UserService $userService): JsonResponse
    {
        $pagination = $requestService->getPagination();
        $users = $userService->listAsPagination($pagination);
        return new JsonResponse($users);
    }

}
