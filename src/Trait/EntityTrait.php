<?php

namespace App\Trait;

use Doctrine\ORM\Mapping as ORM;
trait EntityTrait
{
    #[ORM\Column]
    private ?bool $delete = false;

    public function isDelete(): ?bool
    {
        return $this->delete;
    }

    public function setDelete(bool $delete): static
    {
        $this->delete = $delete;
        return $this;
    }

    public function delete(): static
    {
        $this->delete = true;
        return $this;
    }
}