<?php

namespace App\Services;

use App\ClassRequest\RequestPagination;
use App\Entity\User;
use App\OtherClass\ResultPagination;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }
    public function getUser(User $user): ?User
    {
        return $this->userRepository->findOneBy(['username' => $user->getUsername()]);
    }
    public function register(User $user): User
    {
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        return $this->userRepository->save($user);
    }

    public function listAsPagination(RequestPagination $pagination): ResultPagination
    {

        $resultPagination = new ResultPagination;
        $resultPagination->setRow($this->userRepository->listAsPagination($pagination));
        $resultPagination->setTotal( $this->userRepository->countUsers());
        return $resultPagination;    
    }
}
