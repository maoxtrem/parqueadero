<?php

namespace App\Services;

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
