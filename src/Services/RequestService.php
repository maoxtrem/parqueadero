<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\HttpFoundation\RequestStack;

class RequestService
{


    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getUserForRegister(): User
    {
        $user = new User;
        $request = $this->getRequest();
        if($request instanceof Request){
            $username = $request->getPayload()->getString('username');
            $password = $request->getPayload()->getString('password');
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRoles(['ROLE_USER']);
        }
        return  $user;
    }

  
    private function getRequest(): null|Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
