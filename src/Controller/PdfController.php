<?php

namespace App\Controller;

use App\Services\RequestService;
use App\Services\UserService;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class PdfController extends AbstractController
{


    #[Route(path: '/certificado/pdf', name: 'app_certificado_pdf')]
    public function certificado_pdf(): Response
    {
    
        return $this->render('plantillas/certificado.html');
    }
}