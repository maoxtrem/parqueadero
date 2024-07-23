<?php

namespace App\Services;

use App\ClassRequest\RequestPagination;
use App\OtherClass\ResultPagination;

class PaginationService {

    public function __construct(
        private UserService $userService
        )
    {
    }
    public function getUserPagination(RequestPagination $requestPagination) : ResultPagination {
      return $this->userService->listAsPagination($requestPagination);
    }
}