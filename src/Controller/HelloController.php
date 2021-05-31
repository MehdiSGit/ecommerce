<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController
{

    /**
     * @Route("/hello/{prenom?World}", name="hello")
     */
    public function hello($prenom = "World", Environment $twig)
    {
        $html = $twig->render('hello.html.twig',[
            'prenom' => $prenom,
            'formateur1' => [
                'prenom' => 'Mehdi',
                'nom' => 'Banderas'
            ],
            'formateur2' => [
                'prenom' => 'Zoé',
                'nom' => 'Nathan'
            ]
        ]);
        return new Response($html);
    }
}