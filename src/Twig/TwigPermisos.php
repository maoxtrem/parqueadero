<?php

namespace App\Twig;

use App\Services\PermissionsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigPermisos extends AbstractExtension
{

    public function __construct(private PermissionsService $service)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('permiso', fn () =>  $this->service->permisos()),
        ];
    }
}
