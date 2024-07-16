<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
        $this->uploadFile($user->getFotoFile(), $user->getFoto());
    }

    public function delete(?string $filename)
    {
        if ($filename) {
            $filePath = $this->uploadsDirectory . '/' . $filename;
            file_exists($filePath) && unlink($filePath);
        }
    }

    private function uploadFile(UploadedFile $file, string $name)
    {
        $$file->move(
            $this->uploadsDirectory,
            $name
        );
    }
}
