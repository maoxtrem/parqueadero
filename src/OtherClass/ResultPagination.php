<?php

namespace App\OtherClass;

class ResultPagination
{
    private array $rows = [];
    private int $total = 0;

    public function setRow(array $rows):self
    {
        $this->rows = $rows;
        return $this;
    }

    public function setTotal(int $total):self
    {
        $this->total = $total;
        return $this;
    }


    public function getResult() : array {
        return  [
            "rows" => $this->rows,
            "total" => $this->total,
            "totalNotFiltered" => $this->total - count($this->rows)
        ];
      
    }
}
