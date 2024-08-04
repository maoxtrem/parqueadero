<?php

namespace App\Services;

use App\OtherClass\ResultPermices;

class PermissionsService
{
    public function __construct() {
        
    }

    public function permisos() : ResultPermices {
        return new ResultPermices();
    }
}
