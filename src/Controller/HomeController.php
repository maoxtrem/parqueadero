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
        $this->getUser();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('users', name: 'list_users')]
    public function list(RequestService $requestService, UserService $userService): JsonResponse
    {
        $pagination = $requestService->getPagination();
        $users = $userService->listAsPagination($pagination);
        return new JsonResponse($users);
    }

    #[Route('', name: 'app_index')]
    public function index(): Response
    {   
        return $this->redirectToRoute('app_home_index');
    }
}
