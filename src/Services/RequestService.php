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
        $username = $this->get('username');
        $password = $this->get('password');
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        return  $user;
    }

    public function getPagination(): PaginationService
    {
        $pagination = new PaginationService();
        $search = $this->get('search');
        $sort = $this->get('sort');
        $order = $this->get('order');
        $offset = $this->get('offset');
        $limit = $this->get('limit');

        $pagination->setSearch($search);
        $pagination->setSort($sort);
        $pagination->setOrder($order);
        $pagination->setOffset($offset);
        $pagination->setLimit($limit);

        return $pagination;
    }



    private function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }


    public function get(string $key): ?string
    {
        $request = $this->getRequest();
        if ($request instanceof Request) {
            $value = $request->getPayload()->getString($key);
            if ($value  != '') {
                return $value;
            }
            $value = $request->query->get($key);
            if ($value  != '') {
                return $value;
            }
        }
        return null;
    }
}
