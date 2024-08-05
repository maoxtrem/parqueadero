<?php

namespace App\ClassRequest;

use App\Entity\Pais;

class RequestPais extends RequestCRUD
{

    private ?string $name;


    public function getEntity(): Pais
    {
        $pais = new Pais;
        $pais->setName($this->name);
        return $pais;
    }


    public function getName():?string
    {
        return $this->name;
    }

   
    public function setName(?string $name)
    {
        $this->name = $name;

        return $this;
    }
}
