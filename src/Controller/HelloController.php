<?php

namespace App\Controller;

use App\Taxes\Calculator;
use App\Taxes\Detector;
use Cocur\Slugify\Slugify;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HelloController
{
    // protected $calculator;

    // public function __construct(Calculator $calculator)
    // {
    //     $this->calculator = $calculator;
    // }


    // protected $logger;

    // public function __construct(LoggerInterface $logger)
    // {
    //     $this->logger = $logger;
    // }

    /**
     * @Route("/hello/{prenom}", name="hello", methods={"GET", "POST"})
     */
    public function hello(Request $request, $prenom = "World", LoggerInterface $logger, Calculator $calculator, Slugify $slugify, Environment $twig, Detector $detector)
    {

        dump($detector->detect(101));
        dump($detector->detect(10));
        // $slugify = new Slugify();
        dump($slugify->slugify("Hello World"));
        // $request = Request::createFromGlobals();

        // $age = $request->attributes->get('age');

        // $age = 0;
        // if(!empty($_GET['age'])){
        //     $age = $_GET['age'];
        
        $logger->info("Mon message de log !!!");

        $tva = $calculator->calcul(100);

        dump($tva);

        return new Response("Hello $prenom  !");

        // dd("Vous avez $age ans");
    }
}