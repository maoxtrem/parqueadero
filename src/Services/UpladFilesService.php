<?php

namespace App\Services;

use App\Entity\User;

class UpladFilesService
{

    public function __construct(private string $uploadsDirectory)
    {
        if (!file_exists($this->uploadsDirectory)) {
            mkdir($this->uploadsDirectory, 0755, true);
        }
    }

    public function uploadFileUser(User $user)
    {
        $user->getFotoFile()->move(
            $this->uploadsDirectory,
            $user->getFoto()
        );
    }


    public function delete(?string $filename)
    {
        if ($filename) {
            $filePath = $this->uploadsDirectory . '/' . $filename;
            file_exists($filePath) && unlink($filePath);
        }
    }
}
