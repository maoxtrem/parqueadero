<?php

namespace App\Security;

use App\Entity\User;
use App\Services\RequestService;
use App\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class CustomRegister extends AbstractController
{

    public function __construct(
        private  RequestService $requestService,
        private CsrfTokenManagerInterface $csrfTokenManager,
        private  UserService $userService,
        private  UserPasswordHasherInterface $passwordHasher,
        private TokenStorageInterface $tokenStorage,
    ) {
    }


public function register() : Response {
    if ($this->getUser() instanceof UserInterface) {
        return $this->redirectToRoute('app_home_index');
    }

    $csrfToken = $this->requestService->get('_csrf_token');
    $error = null;
    if ($this->csrfTokenManager->isTokenValid(new CsrfToken('_csrf_token', $csrfToken))) {
        return $this->render('security/index.html.twig', [
            'last_username' => '',
            'error' => ['message' => 'Token fails'],
            'form_login' => false
        ]);
    }

    if ($this->requestService->isMethodPost()) {

        $userRequest = $this->requestService->getUserRegister();
        if (!$userRequest->getUsername()) {
            $error =  ['message' => 'Usuario vacio'];
        }
        if (!$error && !$userRequest->getPassword()) {
            $error =  ['message' => 'password vacio'];
        }

        if ($userRequest->isValid()) {
            $user = $this->userService->getUser($userRequest);
            $password = $userRequest->getPassword();

            if (!$user instanceof User) {
                $user =  $this->userService->register($userRequest);
            }



            if (!$this->passwordHasher->isPasswordValid($user,  $password)) {
                return $this->render('security/index.html.twig', [
                    'last_username' => '',
                    'error' =>  ['message' => 'usuario ya existe pero la contraseña es incorrecta'],
                    'form_login' => false
                ]);
            }
           
            $this->requestService->login($user);
            return $this->redirectToRoute('app_home_index');
        }
    }

    return $this->render('security/index.html.twig', [
        'last_username' => '',
        'error' =>  $error,
        'form_login' => false
    ]);
}
    
}
