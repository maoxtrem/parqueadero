<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UpladFilesService
{

    public function __construct(
        private string $uploadsDirectoryPublic,
        private string $uploadsDirectoryPrivate,
    ) {
        if (!file_exists($this->uploadsDirectoryPublic)) {
            mkdir($this->uploadsDirectoryPublic, 0755, true);
        }
        if (!file_exists($this->uploadsDirectoryPrivate)) {
            mkdir($this->uploadsDirectoryPrivate, 0755, true);
        }
    }

    public function uploadFileUser(User $user)
    {
        $this->uploadFilePublic($user->getFotoFile(), $user->getFoto());
    }

    public function delete(?string $filename)
    {
        if ($filename) {
            $filePath = $this->uploadsDirectoryPublic . '/' . $filename;
            file_exists($filePath) && unlink($filePath);
            $filePath = $this->uploadsDirectoryPrivate . '/' . $filename;
            file_exists($filePath) && unlink($filePath);
        }
    }

    private function uploadFilePublic(UploadedFile $file, string $name)
    {
        $$file->move(
            $this->uploadsDirectoryPublic,
            $name
        );
    }


    private function uploadFilePrivate(UploadedFile $file, string $name)
    {
        $$file->move(
            $this->uploadsDirectoryPrivate,
            $name
        );
    }
}
