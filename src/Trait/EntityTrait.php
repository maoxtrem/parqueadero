<?php

namespace App\Trait;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

trait EntityTrait
{
    #[ORM\Column]
    private ?bool $status = true;

    #[ORM\Column(type: "datetime_immutable")]
    private ?DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?DateTimeImmutable $updatedAt = null;


    public function isActive(): ?bool
    {
        return $this->status;
    }


    public function active(): static
    {
        $this->status = !$this->status;
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
  
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }


    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }


}
