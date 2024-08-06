<?php

namespace App\Services;

class MessagesService
{

    public function login_fail($message = "default message", $icon = "error"): array
    {
        return $this->swal_success($message, $icon);
    }

    public function login_success($message = "redirigiendo al home", $icon = "success"): array
    {
        return $this->swal_success($message, $icon);
    }

    public function username_empty(): array
    {
        return $this->swal_success("campo usuario esta vacio", "error");
    }

    public function password_empty(): array
    {
        return $this->swal_success("campo clave esta vacio", "error");
    }

    public function user_exist(): array
    {
        return $this->swal_success("usuario ya existe", "error");
    }

    public function user_registrated(): array
    {
        return $this->swal_success("usuario registrado con exito", "success");
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


    private function message_backend() : array {
        return[

        ];
    }
}
