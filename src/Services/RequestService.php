<?php

namespace App\Services;

use App\ClassRequest\RequestDepartamento;
use App\ClassRequest\RequestPagination;
use App\ClassRequest\RequestPais;
use App\Entity\Departamento;
use App\Entity\Pais;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use App\Repository\DepartamentoRepository;
use App\Repository\PaisRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use App\Security\CustomAuthenticator;

class RequestService
{


    public function __construct(
        private RequestStack $requestStack,
        private UserAuthenticatorInterface $userAuthenticator,
        private CustomAuthenticator $authenticator,
        private DepartamentoRepository $departamentoRepository,
        private PaisRepository $paisRepository,
        private RequestDepartamento $requestDepartamento,
        private RequestPais $requestPais,
        private RequestPagination $requestPagination
    ) {
    }

    private function getRequest(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }

    public function getUserRegister(): User
    {
        $user = new User();
        $username = $this->get('_username');
        $password = $this->get('_password');
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER']);
        return  $user;
    }

    public function isMethodPost(): bool
    {
        return $this->getRequest()->isMethod('POST');
    }


    public function login(User $user): void
    {

        $this->userAuthenticator->authenticateUser(
            $user,
            $this->authenticator,
            $this->getRequest()
        );
    }



    public function getUserForUpdate(): User
    {
        $user = new User(1);
        $file = $this->get('image');
        $user->setFotoFile($file);
        return  $user;
    }

    public function getPagination(): RequestPagination
    {
        $search = $this->get('search');
        $sort = $this->get('sort');
        $order = $this->get('order');
        $offset = $this->get('offset');
        $limit = $this->get('limit');

        $this->requestPagination->setSearch($search);
        $this->requestPagination->setSort($sort);
        $this->requestPagination->setOrder($order);
        $this->requestPagination->setOffset($offset);
        $this->requestPagination->setLimit($limit);

        return $this->requestPagination;
    }


    public function getPais(): Pais
    {
        $id = $this->get('id') ?? 0;
        return new Pais($id);
    }

    public function getPaisCrud(): RequestPais
    {
        $id = $this->get('id') ?? 0;
        $name = $this->get('name');
        $delete = $this->get('delete');
        
        $this->requestPais->setId($id);
        $this->requestPais->setDelete($delete);
        $this->requestPais->setName($name);

        return $this->requestPais;
    }

    public function getDepartamentoCrud(): RequestDepartamento
    {
        $id = $this->get('id') ?? 0;
        $delete = $this->get('delete');
        $id_pais = $this->get('id_pais');
        $name = $this->get('name');

        $this->requestDepartamento->setId($id);
        $this->requestDepartamento->setDelete($delete);
        $this->requestDepartamento->setIdPais($id_pais);
        $this->requestDepartamento->setName($name);
        return $this->requestDepartamento;
    }




    public function getDepartamento(): Departamento
    {
        $id = $this->get('id') ?? 0;
        return new Departamento($id);
    }


    public function get(string $key): null|string|UploadedFile
    {
        $request = $this->getRequest();
        if ($request instanceof Request) {

            $file = $request->files->get($key);
            if ($file) {
                return $file;
            }
            $post = $request->getPayload()->getString($key);
            if ($post  != '') {
                return $post;
            }
            $get = $request->query->get($key);
            if ($get  != '') {
                return $get;
            }
        }
        return null;
    }
}
