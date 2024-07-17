<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Services\RequestService;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;
#[Route(path: '/register', name: 'app_')]
class UserController extends AbstractController
{
    
    #[Route(path: '/register', name: 'register_form')]
    public function login_register_form(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/register.html.twig');
    }

    #[Route(path: '/user_register', name: 'register')]
    public function login_register(
        RequestService $requestService,
        UserService $userService
        ): JsonResponse
    {
        $user = $requestService->getUserForRegister();
        return $userService->registerUser($user);
    }

    #[Route(path: '/user_update', name: 'user_update')]
    public function update(
        RequestService $requestService,
        UserService $userService
        ): JsonResponse
    {
        $user = $requestService->getUserForUpdate();
        return $userService->userUpdate($user);
    }


}
