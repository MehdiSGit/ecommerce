<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    /**
     * @Route("/hello/{prenom?World}", name="hello")
     */
    public function hello($prenom = "World")
    {
        // $html = $this->twig->render('hello.html.twig',[
        //     'prenom' => $prenom,
        // ]);
        // return new Response($html);
        return $this->render('hello.html.twig', [
            'prenom' => $prenom
        ]);
    }

    /**
     * @Route("/example", name="example")
     */
    public function example() 
    {
        return $this->render('example.html.twig', [
            'age' => 33
            ]);
    }
}