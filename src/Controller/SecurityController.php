<?php

namespace App\Controller;

use App\Entity\User;
use App\Services\RequestService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Csrf\CsrfToken;

#[Route(path: '/', name: 'app_')]
class SecurityController extends AbstractController
{

    #[Route(name: 'redirect_home')]
    public function redirect_home(): Response
    {
        return $this->redirectToRoute('app_home_index');
    }

    #[Route(path: 'login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home_index');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'form_login' => true
        ]);
    }

    #[Route(path: 'register', name: 'register')]
    public function register(
        RequestService $requestService,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserService $userService,
        UserPasswordHasherInterface $passwordHasher,
    ): Response {
        if ($this->getUser() instanceof UserInterface) {
            return $this->redirectToRoute('app_home_index');
        }

        $csrfToken = $requestService->get('_csrf_token');
        $error = null;
        if ($csrfTokenManager->isTokenValid(new CsrfToken('_csrf_token', $csrfToken))) {
            return $this->render('security/index.html.twig', [
                'last_username' => '',
                'error' => ['message' => 'Token fails'],
                'form_login' => false
            ]);
        }

        if ($requestService->isMethodPost()) {

            $userRequest = $requestService->getUserRegister();
            if (!$userRequest->getUsername()) {
                $error =  ['message' => 'Usuario vacio'];
            }
            if (!$error && !$userRequest->getPassword()) {
                $error =  ['message' => 'password vacio'];
            }

            if ($userRequest->isValid()) {
                $user = $userService->getUser($userRequest);
                $password = $userRequest->getPassword();

                if (!$user instanceof User) {
                    $user =  $userService->register($userRequest);
                }



                if (!$passwordHasher->isPasswordValid($user,  $password)) {
                    return $this->render('security/index.html.twig', [
                        'last_username' => '',
                        'error' =>  ['message' => 'usuario ya existe pero la contraseña es incorrecta'],
                        'form_login' => false
                    ]);
                }
               
                $requestService->login($user);
                return $this->redirectToRoute('app_home');
            }
        }

        return $this->render('security/index.html.twig', [
            'last_username' => '',
            'error' =>  $error,
            'form_login' => false
        ]);
    }
    #[Route(path: 'logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException();
    }

}
