<?php

namespace App\Services;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
class UserService
{

    public function __construct(
        private MessagesService $messagesService,
        private UserRepository $userRepository
        )
    {
    }
    public function registerUser(User $user): JsonResponse
    {
        return new JsonResponse();
    }

  
}
