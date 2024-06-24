<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MessagesService
{

    public function login_fail($message = "default message", $icon = "error"): array
    {
        return $this->swal_success($message, $icon);
    }

    private function swal_success($message = "default message", $icon = "success"): array
    {
        return [
            "position" => "center",
            "icon" => $icon,
            "title" => $message,
            "showConfirmButton" => false,
            "timer" => 1500
        ];
    }
}
