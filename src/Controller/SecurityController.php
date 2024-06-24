<?php

namespace App\Controller;

use App\Services\RequestService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

class SecurityController extends AbstractController
{


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): RedirectResponse|JsonResponse
    {
        if ($authenticationUtils->getLastAuthenticationError() == null) {
            return $this->redirectToRoute('app_login_form');
        }
    }


    #[Route(path: '/login/form', name: 'app_login_form')]
    public function login_form(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/login.html.twig');
    }

    #[Route(path: '/register/form', name: 'app_register_form')]
    public function login_register_form(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/register.html.twig');
    }

    #[Route(path: '/register', name: 'app_register')]
    public function login_register(RequestService $requestService,UserService $userService): JsonResponse
    {
        $user = $requestService->getUserForRegister();
        return $userService->registerUser($user);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
