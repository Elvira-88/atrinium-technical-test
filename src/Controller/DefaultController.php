<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// AbstractController es un controlador de symfony que pone
// a disposición nuestra multitud de características.

class DefaultController extends AbstractController
{
    const COMPANIES = [
        ['name' => 'Modas Loli', 'phone' => 954278325, 'email' => 'loli@correo.com', 'sector' => 'Textil'],
        ['name' => 'Centro Estética Carmen', 'phone' => 954278325, 'email' => 'carmen@correo.com', 'sector' => 'Belleza'],
        ['name' => 'Restaurante Apolo', 'phone' => 954278325, 'email' => 'apolo@correo.com', 'sector' => 'Hostelería'],
        ['name' => 'Clínica Márquez', 'phone' => 954278325, 'email' => 'marquez@correo.com', 'sector' => 'Salud'],        
    ];

    /**
     * @Route("/default", name="default_index")
     * 
     * La clase ruta debe estar precedida en los comentarios por una arroba.
     * El primer parámetro de Route es la URL a la que queremos asociar la acción.
     * El segundo parámetro de Route es el nombre que queremos dar a la ruta.
     */ 
    public function index(): Response
    {
        // Una acción siempre debe devolver una respesta.
        // Por defecto deberá ser un objeto de la clase,
        // Symfony\Component\HttpFoundation\Response


        // render() es un método heredado de AbstractController
        // que devuelve el contenido declarado en una plantilla de Twig.

        return $this->render('default/index.html.twig', [
            'companies' => self::COMPANIES
        ]);
    }
}