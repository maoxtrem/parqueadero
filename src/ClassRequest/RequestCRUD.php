<?php

namespace App\ClassRequest;

class RequestCRUD
{
    private int $id = 0;
    private int $delete = 0;



    public function getId():int
    {
        return $this->id;
    }

    public function isUpdate(): bool
    {
        return $this->id > 0 && $this->delete == 0;
    }

    public function isCreate(): bool
    {
        return $this->id == 0 && $this->delete == 0;
    }

    public function isDelete()
    {
        return $this->delete == 1;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    public function setDelete(int $delete)
    {
        $this->delete = $delete;

        return $this;
    }

  
  
}
