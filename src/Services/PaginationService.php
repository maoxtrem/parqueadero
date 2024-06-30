<?php

namespace App\Services;

class PaginationService
{

    private ?string $search;
    private ?string $sort;
    private ?string $order;
    private ?int $offset;
    private ?int $limit;

    public function __construct()
    {

    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch( ?string $search): ?string
    {
        return $this->search = $search;
    }

    public function getSort(): ?string
    {
        return $this->sort;
    }

    public function setSort( ?string $sort): ?string
    {
        return $this->sort = $sort;
    }

    public function setOrder( ?string $order): ?string
    {
        return $this->order = $order;
    }


    public function getOrder(): ?string
    {
        return $this->order;
    }

    public function setOffset(?int $offset): ?int
    {
        return $this->offset = $offset;
    }


    public function getOffset(): ?int
    {
        return $this->offset;
    }

    public function setLimit(?int $limit): ?int
    {
        return $this->limit = $limit;
    }


    public function getLimit(): ?int
    {
        return $this->limit;
    }
}
