<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
#[Route(path: '/', name: 'app_')]
class SecurityController extends AbstractController
{


    #[Route(path: 'login_user', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): RedirectResponse|JsonResponse
    {
        if ($authenticationUtils->getLastAuthenticationError() == null) {
            return $this->redirectToRoute('app_login_form');
        }
    }


    #[Route(path: 'login', name: 'login_form')]
    public function login_form(): Response
    {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('home_index');
        }

        return $this->render('security/login.html.twig');
    }



    #[Route(path: 'logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
