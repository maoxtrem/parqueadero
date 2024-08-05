<?php

namespace App\OtherClass;


class ResultPermices
{

    private bool $create = true;
    private bool $read = false;
    private bool $update = false;
    private bool $delete = false;



    public function getCreate()
    {
        return $this->create;
    }

    public function getRead()
    {
        return $this->read;
    }

    public function getUpdate()
    {
        return $this->update;
    }

    public function getDelete()
    {
        return $this->delete;
    }
}
