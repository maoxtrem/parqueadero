<?php

namespace App\Services;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{

    public function __construct(
        private MessagesService $messagesService,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }
    public function registerUser(User $user): JsonResponse
    {

        if ($user->getUsername() == null) {
            return new JsonResponse(["message" => $this->messagesService->username_empty()]);
        }
        if ($user->getPassword() == null) {
            return new JsonResponse(["message" => $this->messagesService->password_empty()]);
        }

        $userdb =  $this->userRepository->findOneBy(['username' => $user->getUsername()]);

        if ($userdb  instanceof User) {
            return new JsonResponse(["message" => $this->messagesService->user_exist()]);
        }
        $user = $this->encrytarPassword($user);
        $this->userRepository->save($user);
        return new JsonResponse(["message" => $this->messagesService->user_registrated()]);
    }

    public function userUpdate(User $user): JsonResponse
    {
        $file = $user->getFotoFile();
        $user = $this->userRepository->findOneBy(['id' => $user]);
        $user->setFotoFile($file);
        $this->userRepository->save($user);
        return new JsonResponse(["message" => $this->messagesService->user_registrated()]);
    }

    public function encrytarPassword(User $user): User
    {

        $user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $user,
                $user->getPassword()
            )
        );
        return $user;
    }


    public function listAsPagination(PaginationService $pagination): array
    {

        $rows = $this->userRepository->listAsPagination($pagination);
        $total = count($this->userRepository->userAll());
        return  [
            "rows" => $rows,
            "total" => $total,
            "totalNotFiltered" => $total - count($rows)
        ];
    }
}
