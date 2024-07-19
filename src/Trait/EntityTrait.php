<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    #[ORM\Column]
    private ?bool $delet = false;

    public function isDelete(): ?bool
    {
        return $this->delet;
    }

    public function setDelete(bool $delete): static
    {
        $this->delet = $delete;
        return $this;
    }

    public function delete(): static
    {
        $this->delet = true;
        return $this;
    }


    public function isUpdate(): bool
    {
        return $this->id > 0;
    }

    public function isCreate(): bool
    {
        return !$this->isUpdate();
    }
}
