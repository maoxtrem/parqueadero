<?php

namespace App\Controller;

use App\OtherClass\ResultPermices;
use App\Security\CustomLogin;
use App\Security\CustomRegister;
use App\Services\PermisosService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/', name: 'app_')]
class SecurityController extends AbstractController
{

    #[Route(path: 'test', name: 'test')]
    public function test(): Response
    {
        return $this->render('test.html');
    }

    #[Route(name: 'redirect_home')]
    public function redirect_home(): Response
    {
        return $this->redirectToRoute('app_home_index');
    }


    #[Route(path: 'login', name: 'login')]
    public function login(CustomLogin $customLogin): Response
    {
        return $customLogin->login();
    }

    #[Route(path: 'register', name: 'register')]
    public function register(CustomRegister $customRegister): Response
    {
        return $customRegister->register();
    }

    #[Route(path: 'logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException();
    }


}
