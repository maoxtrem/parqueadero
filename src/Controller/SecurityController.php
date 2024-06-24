<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController
{


    #[Route(path: '/login', name: 'app_login')]
    public function login(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('security/login.html.twig');
    }
    #[Route(path: '/login/succes', name: 'app_login_success')]
    public function login_succes(): JsonResponse
    {

        return new JsonResponse([], 200);
    }
    #[Route(path: '/login/bad', name: 'app_login_bad')]
    public function login_bad(AuthenticationUtils $authenticationUtils): JsonResponse
    {

        $error = $authenticationUtils->getLastAuthenticationError();

  
        return new JsonResponse(["error" => $error], 200);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
