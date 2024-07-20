<?php

namespace App\Services;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(private UserRepository $userRepository,private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function getUser(User $user): ?User
    {
        return $this->userRepository->findOneBy(['username'=>$user->getUsername()]);
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
}
