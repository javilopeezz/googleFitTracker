<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use App\Service\GoogleSheetServices;

class frontController extends AbstractController
{

    #[Route(path: '/', name: 'Inicio')]
    public function inicio(): Response
    {
        
        $html = $this->render('inicio.html.twig');
        return $html;
        
    }

    #[Route(path: '/sobre-nosotros', name: 'SobreNosotros')]
    public function sobreNosotros(): Response
    {
        
        $html = $this->render('sobreNosotros.html.twig');
        return $html;
        
    }

    #[Route(path: '/datos', name: 'Datos')]
    public function datos(): Response
    {
        
        $html = $this->render('datos.html.twig');
        return $html;
        
    }

    #[Route(path: '/datos-hoy', name: 'DatosHoy')]
    public function datosHoy(): Response
    {
        
        $html = $this->render('datosHoy.html.twig');
        return $html;
        
    }

    #[Route(path: '/datos-ayer', name: 'DatosAyer')]
    public function datosAyer(): Response
    {
        
        $html = $this->render('datosAyer.html.twig');
        return $html;
        
    }

    #[Route(path: '/datos-historial', name: 'DatosHistorial')]
    public function datosHistorial(): Response
    {
        
        $html = $this->render('datosHistorial.html.twig');
        return $html;
        
    }
}
